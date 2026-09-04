<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\User;
use App\Notifications\TaskEventNotification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Auth\Access\AuthorizationException;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;

    protected function beforeCreate(): void
    {
        $actor = auth()->user();
        $data = $this->form->getRawState();

        if (! $actor || ! $actor->can('manage-tasks')) {
            throw new AuthorizationException('You are not authorized to create tasks.');
        }

        if ($actor->hasRole('Admin')) {
            $branchIds = $actor->branches()->pluck('branches.id')->map(fn ($id) => (int) $id)->all();
            $branchId = isset($data['branch_id']) && $data['branch_id'] !== '' ? (int) $data['branch_id'] : null;

            if ($branchId !== null && ! in_array($branchId, $branchIds, true)) {
                throw new AuthorizationException('You can only create tasks for your assigned branches.');
            }

            if (! empty($data['assigned_to'])) {
                $assignee = User::query()
                    ->whereKey((int) $data['assigned_to'])
                    ->where('status', 'active')
                    ->whereHas('roles', fn ($query) => $query->where('name', 'Staff'))
                    ->where(function ($query) use ($branchIds): void {
                        $query->whereIn('primary_branch_id', $branchIds)
                            ->orWhereHas('branches', fn ($query) => $query->whereIn('branches.id', $branchIds));
                    })
                    ->exists();

                if (! $assignee) {
                    throw new AuthorizationException('You can only assign tasks to active staff within your assigned branches.');
                }
            }
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['assigned_by'] = auth()->id();

        return $data;
    }

    protected function afterCreate(): void
    {
        if ($this->record->assignee) {
            $this->record->assignee->notify(new TaskEventNotification(
                $this->record,
                'New task assigned',
                'You have been assigned this task.',
            ));
        }
    }
}
