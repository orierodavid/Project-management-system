<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        $state = $this->form->getRawState();
        $role = $state['roles'] ?? 'Staff';
        $branches = $state['branches'] ?? [];

        $this->record->syncRoles([$role]);
        $this->record->branches()->sync($branches ?: ($this->record->primary_branch_id ? [$this->record->primary_branch_id] : []));
    }
}
