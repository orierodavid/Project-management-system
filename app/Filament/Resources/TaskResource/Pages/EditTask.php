<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Carbon;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['status'] ?? null) === 'done' && $this->record->completed_at === null) {
            $data['completed_at'] = Carbon::now();
        }

        if (($data['status'] ?? null) !== 'done') {
            $data['completed_at'] = null;
        }

        return $data;
    }
}
