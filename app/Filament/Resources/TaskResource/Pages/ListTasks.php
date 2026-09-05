<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [
            Action::make('board')
                ->label('Board')
                ->icon('heroicon-o-view-columns')
                ->url(TaskResource::getUrl('board'))
                ->color('gray'),
        ];

        if (auth()->user()?->can('manage-tasks')) {
            $actions[] = CreateAction::make()->label('New task')->icon('heroicon-o-plus');
        }

        return $actions;
    }
}
