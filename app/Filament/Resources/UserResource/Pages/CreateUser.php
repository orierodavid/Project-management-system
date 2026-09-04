<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        $role = $this->data['roles'] ?? 'Staff';
        $branches = $this->data['branches'] ?? [];

        $this->record->syncRoles([$role]);
        if ($branches) {
            $this->record->branches()->sync($branches);
        } elseif ($this->record->primary_branch_id) {
            $this->record->branches()->sync([$this->record->primary_branch_id]);
        }
    }
}
