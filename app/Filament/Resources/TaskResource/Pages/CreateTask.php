<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Notifications\TaskEventNotification;
use Filament\Resources\Pages\CreateRecord;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;

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
                'You have been assigned a new task.',
            ));
        }
    }
}
