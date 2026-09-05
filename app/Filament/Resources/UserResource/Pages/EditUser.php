<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Auth\Access\AuthorizationException;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $previousRole = null;

    /** @var array<int, int> */
    protected array $previousBranches = [];

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['roles'] = $this->record->roles()->pluck('name')->first();
        $data['branches'] = $this->record->branches()->pluck('branches.id')->all();

        return $data;
    }

    protected function beforeSave(): void
    {
        $actor = Filament::auth()->user();
        $state = $this->form->getRawState();

        if (! $actor?->can('manage-users')) {
            throw new AuthorizationException('You are not authorized to edit users.');
        }

        $this->previousRole = $this->record->roles()->pluck('name')->first();
        $this->previousBranches = $this->record->branches()->pluck('branches.id')->map(fn ($id) => (int) $id)->sort()->values()->all();

        if ($actor->hasRole('Admin')) {
            if (! $this->record->hasRole('Staff')) {
                throw new AuthorizationException('Admins can only edit staff accounts.');
            }

            $allowedBranches = $actor->branches()->pluck('branches.id')->map(fn ($id) => (int) $id)->all();
            $primaryBranch = (int) ($state['primary_branch_id'] ?? 0);
            $branches = array_map('intval', $state['branches'] ?? []);

            if (! in_array($primaryBranch, $allowedBranches, true) || array_diff($branches, $allowedBranches)) {
                throw new AuthorizationException('You can only manage staff within your assigned branches.');
            }
        }
    }

    protected function afterSave(): void
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

        $newBranches = collect($effectiveBranches)->sort()->values()->all();

        if ($this->previousRole !== $role || $this->previousBranches !== $newBranches) {
            activity('users')
                ->performedOn($this->record)
                ->withProperties([
                    'role' => ['before' => $this->previousRole, 'after' => $role],
                    'branches' => ['before' => $this->previousBranches, 'after' => $newBranches],
                ])
                ->log('Access updated');
        }
    }
}
