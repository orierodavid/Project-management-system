<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\User;
use App\Notifications\TaskEventNotification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Carbon;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected ?string $previousStatus = null;
    protected ?int $previousAssignee = null;

    protected function beforeSave(): void
    {
        $actor = auth()->user();
        $data = $this->form->getRawState();

        if (! $actor || ! ($actor->can('manage-tasks') || $actor->can('update-own-tasks'))) {
            throw new AuthorizationException('You are not authorized to edit tasks.');
        }

        if ($actor->hasRole('Staff')) {
            if (! $actor->can('update-own-tasks') || (int) $this->record->assigned_to !== (int) $actor->id) {
                throw new AuthorizationException('You can only update tasks assigned to you.');
            }

            return;
        }

        if ($actor->hasRole('Admin')) {
            $branchIds = $actor->branches()->pluck('branches.id')->map(fn ($id) => (int) $id)->all();
            $branchId = isset($data['branch_id']) && $data['branch_id'] !== '' ? (int) $data['branch_id'] : null;

            $recordInScope = $this->record->branch_id === null
                || in_array((int) $this->record->branch_id, $branchIds, true);

            if (! $recordInScope || ($branchId !== null && ! in_array($branchId, $branchIds, true))) {
                throw new AuthorizationException('You can only manage tasks within your assigned branches.');
            }

            if (! empty($data['assigned_to'])) {
                $assigneeAllowed = User::query()
                    ->whereKey((int) $data['assigned_to'])
                    ->where('status', 'active')
                    ->whereHas('roles', fn ($query) => $query->where('name', 'Staff'))
                    ->where(function ($query) use ($branchIds): void {
                        $query->whereIn('primary_branch_id', $branchIds)
                            ->orWhereHas('branches', fn ($query) => $query->whereIn('branches.id', $branchIds));
                    })
                    ->exists();

                if (! $assigneeAllowed) {
                    throw new AuthorizationException('You can only assign tasks to active staff within your assigned branches.');
                }
            }
        }
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->previousStatus = $this->record->status;
        $this->previousAssignee = $this->record->assigned_to;

        if (auth()->user()?->hasRole('Staff')) {
            $data = ['status' => $data['status'] ?? $this->record->status];
        }

        if (($data['status'] ?? null) === 'done') {
            $data['completed_at'] ??= Carbon::now();
            $data['is_overdue'] = false;
        } elseif (($data['deadline'] ?? $this->record->deadline)?->isPast()) {
            $data['completed_at'] = null;
            $data['is_overdue'] = true;
        } else {
            $data['completed_at'] = null;
            $data['is_overdue'] = false;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->refresh()->load('assignee');

        if ($this->record->assigned_to && $this->record->assigned_to !== $this->previousAssignee && $this->record->assignee) {
            $this->record->assignee->notify(new TaskEventNotification(
                $this->record,
                'New task assigned',
                'You have been assigned this task.',
            ));
        }

        if ($this->previousStatus !== null && $this->record->status !== $this->previousStatus && $this->record->assignee && $this->record->assignee->id !== auth()->id()) {
            $this->record->assignee->notify(new TaskEventNotification(
                $this->record,
                'Task status changed',
                'The task status changed from '.ucwords(str_replace('_', ' ', $this->previousStatus)).' to '.ucwords(str_replace('_', ' ', $this->record->status)).'.',
            ));
        }
    }
}
