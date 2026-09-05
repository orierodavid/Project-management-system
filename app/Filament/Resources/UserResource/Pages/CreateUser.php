<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Auth\Access\AuthorizationException;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function beforeCreate(): void
    {
        $actor = Filament::auth()->user();
        $state = $this->form->getRawState();

        if (! $actor || ! ($actor->hasRole('Super Admin') || $actor->hasRole('Admin'))) {
            throw new AuthorizationException('You are not authorized to create users.');
        }

        if ($actor->hasRole('Admin')) {
            $allowedBranches = $actor->branches()->pluck('branches.id')->map(fn ($id) => (int) $id)->all();
            $primaryBranch = (int) ($state['primary_branch_id'] ?? 0);
            $branches = array_map('intval', $state['branches'] ?? []);

            if (! in_array($primaryBranch, $allowedBranches, true)) {
                throw new AuthorizationException('You can only create staff for your assigned branches.');
            }

            if (array_diff($branches, $allowedBranches)) {
                throw new AuthorizationException('You can only grant access to your assigned branches.');
            }
        }
    }

    protected function afterCreate(): void
    {
        $actor = Filament::auth()->user();
        $state = $this->form->getRawState();
        $role = $state['roles'] ?? 'Staff';
        $branches = array_map('intval', $state['branches'] ?? []);

        if ($actor?->hasRole('Admin')) {
            $role = 'Staff';
        }

        $this->record->syncRoles([$role]);
        $effectiveBranches = $branches ?: array_filter([(int) $this->record->primary_branch_id]);
        $this->record->branches()->sync($effectiveBranches);

        activity('users')
            ->performedOn($this->record)
            ->withProperties([
                'role' => ['before' => null, 'after' => $role],
                'branches' => ['before' => [], 'after' => array_values($effectiveBranches)],
            ])
            ->log('Access assigned');
    }
}
