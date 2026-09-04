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
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Organization';

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('manage-users') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
            TextInput::make('phone')->tel()->maxLength(30),
            TextInput::make('password')->password()->revealable()
                ->required(fn (string $operation): bool => $operation === 'create')
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)),
            Select::make('department_id')->label('Department')
                ->options(Department::query()->where('is_active', true)->orderBy('name')->pluck('name', 'id'))
                ->searchable()->preload(),
            Select::make('primary_branch_id')->label('Primary branch')
                ->options(Branch::query()->where('is_active', true)->orderBy('name')->pluck('name', 'id'))
                ->searchable()->preload(),
            Select::make('status')->options(['active' => 'Active', 'suspended' => 'Suspended'])->required()->default('active'),
            Select::make('roles')->label('Role')
                ->options(fn () => Role::query()->orderBy('name')->pluck('name', 'name'))
                ->required()->default('Staff')->dehydrated(false),
            Select::make('branches')->label('Branch access')->multiple()
                ->options(Branch::query()->where('is_active', true)->orderBy('name')->pluck('name', 'id'))
                ->preload()->searchable()->dehydrated(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('email')->searchable(),
            TextColumn::make('department.name')->label('Department')->sortable(),
            TextColumn::make('primaryBranch.name')->label('Branch')->sortable(),
            TextColumn::make('roles.name')->badge()->label('Role'),
            TextColumn::make('status')->badge(),
        ])->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
