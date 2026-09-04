<?php

namespace App\Filament\Resources\TaskResource\RelationManagers;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Form $form): Form
    {
        return $form->schema([
            Textarea::make('comment')
                ->required()
                ->minLength(2)
                ->maxLength(5000)
                ->rows(5)
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                TextColumn::make('user.name')->label('By')->sortable(),
                TextColumn::make('comment')->wrap()->limit(160),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->visible(fn (): bool => (bool) auth()->user()?->can('comment-on-tasks'))
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();

                        return $data;
                    }),
            ])
            ->actions([
                DeleteAction::make()
                    ->visible(fn (Model $record): bool => (bool) (auth()->user()?->can('manage-tasks') || (int) $record->user_id === (int) auth()->id())),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
