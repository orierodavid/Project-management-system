<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\User;
use App\Notifications\TaskEventNotification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Carbon;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected ?string $previousStatus = null;
    protected ?int $previousAssignee = null;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->previousStatus = $this->record->status;
        $this->previousAssignee = $this->record->assigned_to;

        if (($data['status'] ?? null) === 'done' && $this->record->completed_at === null) {
            $data['completed_at'] = Carbon::now();
        }

        if (($data['status'] ?? null) !== 'done') {
            $data['completed_at'] = null;
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
