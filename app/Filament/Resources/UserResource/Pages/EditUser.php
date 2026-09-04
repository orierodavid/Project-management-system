<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['roles'] = $this->record->roles()->pluck('name')->first();
        $data['branches'] = $this->record->branches()->pluck('branches.id')->all();

        return $data;
    }

    protected function afterSave(): void
    {
        $role = $this->data['roles'] ?? 'Staff';
        $branches = $this->data['branches'] ?? [];

        $this->record->syncRoles([$role]);
        $this->record->branches()->sync($branches ?: array_filter([$this->record->primary_branch_id]));
    }
}
