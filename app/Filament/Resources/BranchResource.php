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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\ValidationException;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'People';
    protected static ?string $navigationLabel = 'Branches';
    protected static ?int $navigationSort = 30;

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
            TextInput::make('radius_meters')->numeric()->integer()->required()->minValue(1)->default(100)->maxValue(50000),
            Toggle::make('is_active')->default(false),
        ]);
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        static::validateCoordinates($data);
        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        static::validateCoordinates($data);
        return $data;
    }

    protected static function validateCoordinates(array $data): void
    {
        if (! ($data['is_active'] ?? false)) return;
        if ((float) ($data['latitude'] ?? 0) === 0.0 && (float) ($data['longitude'] ?? 0) === 0.0) {
            throw ValidationException::withMessages(['latitude' => 'An active branch must have real GPS coordinates. 0,0 is not a valid configured workplace location.']);
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Branch')
                    ->searchable()->sortable()
                    ->weight('semibold'),
                TextColumn::make('address')
                    ->label('Location')
                    ->limit(55)
                    ->wrap()
                    ->placeholder('No address provided'),
                TextColumn::make('radius_meters')
                    ->label('Geofence radius')
                    ->suffix(' m')
                    ->sortable()
                    ->alignEnd(),
                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->color('gray'),
            ])
            ->defaultSort('name')
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50, 100]);
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
