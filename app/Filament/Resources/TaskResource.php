<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages\CreateTask;
use App\Filament\Resources\TaskResource\Pages\EditTask;
use App\Filament\Resources\TaskResource\Pages\ListTasks;
use App\Filament\Resources\TaskResource\RelationManagers\AttachmentsRelationManager;
use App\Filament\Resources\TaskResource\RelationManagers\CommentsRelationManager;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Task;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Work Management';

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return (bool) ($user?->can('manage-tasks') || $user?->can('view-assigned-tasks'));
    }

    public static function canCreate(): bool
    {
        return (bool) auth()->user()?->can('manage-tasks');
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();
        return (bool) ($user?->can('manage-tasks') || ($user?->can('update-own-tasks') && (int) $record->assigned_to === (int) $user->id));
    }

    public static function canDelete($record): bool
    {
        return (bool) auth()->user()?->can('manage-tasks');
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $query = parent::getEloquentQuery()->with(['assignee', 'department', 'branch']);

        if ($user?->hasRole('Staff')) {
            $query->where('assigned_to', $user->id);
        } elseif ($user?->hasRole('Admin')) {
            $branchIds = $user->branches()->pluck('branches.id');
            $query->where(function (Builder $q) use ($branchIds) {
                $q->whereIn('branch_id', $branchIds)->orWhereNull('branch_id');
            });
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        $staff = auth()->user()?->hasRole('Staff');

        return $form->schema([
            TextInput::make('title')->required()->maxLength(255),
            RichEditor::make('description')->columnSpanFull(),
            Select::make('department_id')
                ->label('Department')
                ->options(Department::query()->where('is_active', true)->orderBy('name')->pluck('name', 'id'))
                ->searchable()->preload()
                ->disabled($staff),
            Select::make('branch_id')
                ->options(Branch::query()->where('is_active', true)->orderBy('name')->pluck('name', 'id'))
                ->searchable()->preload()
                ->disabled($staff),
            Select::make('assigned_to')
                ->label('Assignee')
                ->options(User::query()->where('status', 'active')->orderBy('name')->pluck('name', 'id'))
                ->searchable()->preload()
                ->disabled($staff),
            Select::make('priority')
                ->options(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'])
                ->required()->default('medium')
                ->disabled($staff),
            Select::make('status')
                ->options(['todo' => 'To do', 'in_progress' => 'In progress', 'review' => 'Review', 'done' => 'Done'])
                ->required()->default('todo'),
            DateTimePicker::make('deadline')->seconds(false)->native(false)->disabled($staff),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->searchable()->sortable()->limit(45),
            TextColumn::make('assignee.name')->label('Assigned to')->searchable()->sortable(),
            TextColumn::make('department.name')->label('Department')->sortable(),
            TextColumn::make('priority')->badge(),
            TextColumn::make('status')->badge(),
            TextColumn::make('deadline')->dateTime()->sortable(),
        ])->defaultSort('deadline');
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
            AttachmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'edit' => EditTask::route('/{record}/edit'),
        ];
    }
}
