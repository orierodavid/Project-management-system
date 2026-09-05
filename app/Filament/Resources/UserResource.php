<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\Branch;
use App\Models\Department;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'People';
    protected static ?string $navigationLabel = 'Users';
    protected static ?int $navigationSort = 10;

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('manage-users') ?? false;
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        return (bool) ($user?->hasRole('Super Admin') || $user?->hasRole('Admin'));
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();
        if (! $user?->can('manage-users')) return false;
        if ($user->hasRole('Super Admin')) return true;
        if (! $user->hasRole('Admin') || ! $record->hasRole('Staff')) return false;
        $branchIds = $user->branches()->pluck('branches.id');
        return $record->branches()->whereIn('branches.id', $branchIds)->exists() || $branchIds->contains($record->primary_branch_id);
    }

    public static function canDelete($record): bool
    {
        $user = auth()->user();
        return (bool) ($user?->hasRole('Super Admin') && (int) $user->id !== (int) $record->id);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $query = parent::getEloquentQuery()->with(['department', 'primaryBranch', 'roles']);
        if ($user?->hasRole('Admin')) {
            $branchIds = $user->branches()->pluck('branches.id');
            $query->whereHas('roles', fn (Builder $q) => $q->where('name', 'Staff'))
                ->where(function (Builder $q) use ($branchIds): void {
                    $q->whereIn('primary_branch_id', $branchIds)
                        ->orWhereHas('branches', fn (Builder $q) => $q->whereIn('branches.id', $branchIds));
                });
        }
        return $query;
    }

    public static function form(Form $form): Form
    {
        $actor = auth()->user();
        $isSuperAdmin = (bool) $actor?->hasRole('Super Admin');
        $branchIds = $actor?->branches()->pluck('branches.id')->all() ?? [];
        $branchQuery = Branch::query()->where('is_active', true)->orderBy('name');
        if (! $isSuperAdmin) $branchQuery->whereIn('id', $branchIds);
        return $form->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
            TextInput::make('phone')->tel()->maxLength(30),
            TextInput::make('password')->password()->revealable()->required(fn (string $operation): bool => $operation === 'create')->dehydrated(fn (?string $state): bool => filled($state))->dehydrateStateUsing(fn (string $state): string => Hash::make($state)),
            Select::make('department_id')->label('Department')->options(Department::query()->where('is_active', true)->orderBy('name')->pluck('name', 'id'))->searchable()->preload(),
            Select::make('primary_branch_id')->label('Primary branch')->options($branchQuery->pluck('name', 'id'))->searchable()->preload()->required(),
            Select::make('status')->options(['active' => 'Active', 'suspended' => 'Suspended'])->required()->default('active'),
            Select::make('roles')->label('Role')->options($isSuperAdmin ? Role::query()->orderBy('name')->pluck('name', 'name') : ['Staff' => 'Staff'])->required()->default('Staff')->dehydrated(false),
            Select::make('branches')->label('Branch access')->multiple()->options($branchQuery->pluck('name', 'id'))->preload()->searchable()->dehydrated(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('User')
                    ->searchable()->sortable()
                    ->weight('semibold')
                    ->description(fn (User $record): string => $record->email),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('department.name')
                    ->label('Department')
                    ->sortable()
                    ->placeholder('—')
                    ->wrap(),
                TextColumn::make('primaryBranch.name')
                    ->label('Primary branch')
                    ->sortable()
                    ->placeholder('—')
                    ->wrap(),
                TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Super Admin' => 'danger',
                        'Admin' => 'info',
                        'Staff' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => ucfirst($state ?? ''))
                    ->color(fn (?string $state): string => $state === 'active' ? 'success' : 'danger'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(['active' => 'Active', 'suspended' => 'Suspended']),
                SelectFilter::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name'),
            ])
            ->defaultSort('name')
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50, 100]);
    }

    public static function getPages(): array
    {
        return ['index' => ListUsers::route('/'), 'create' => CreateUser::route('/create'), 'edit' => EditUser::route('/{record}/edit')];
    }
}
