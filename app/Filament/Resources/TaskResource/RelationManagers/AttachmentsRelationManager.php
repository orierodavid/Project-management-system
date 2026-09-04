<?php

namespace App\Filament\Resources\TaskResource\RelationManagers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'attachments';

    public function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('path')
                ->label('Attachment')
                ->disk('public')
                ->directory('task-attachments')
                ->required()
                ->maxSize(10240)
                ->downloadable()
                ->openable(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('original_name')
            ->columns([
                TextColumn::make('original_name')->label('File')->searchable(),
                TextColumn::make('mime_type')->label('Type'),
                TextColumn::make('size')->formatStateUsing(fn ($state): string => $state ? number_format($state / 1024, 1).' KB' : '—'),
                TextColumn::make('uploader.name')->label('Uploaded by'),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->visible(fn (): bool => (bool) auth()->user()?->can('upload-task-attachments'))
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['uploaded_by'] = auth()->id();
                        $data['disk'] = 'public';
                        return $data;
                    }),
            ])
            ->actions([
                DeleteAction::make()
                    ->visible(fn (Model $record): bool => (bool) (auth()->user()?->can('manage-tasks') || (int) $record->uploaded_by === (int) auth()->id())),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
