<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages\CreateBranch;
use App\Filament\Resources\BranchResource\Pages\EditBranch;
use App\Filament\Resources\BranchResource\Pages\ListBranches;
use App\Models\Branch;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Organization';

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('manage-branches') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('address')->maxLength(255),
            TextInput::make('latitude')->numeric()->required()->minValue(-90)->maxValue(90),
            TextInput::make('longitude')->numeric()->required()->minValue(-180)->maxValue(180),
            TextInput::make('radius_meters')->numeric()->integer()->required()->minValue(1)->default(100),
            Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('address')->limit(35),
            TextColumn::make('radius_meters')->label('Radius')->suffix(' m')->sortable(),
            IconColumn::make('is_active')->boolean(),
            TextColumn::make('created_at')->dateTime()->sortable(),
        ])->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBranches::route('/'),
            'create' => CreateBranch::route('/create'),
            'edit' => EditBranch::route('/{record}/edit'),
        ];
    }
}
