<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class CompanySettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'System';

    protected static ?string $navigationLabel = 'Company Settings';

    protected static string $view = 'filament.pages.company-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::current()->toArray());
    }

    public static function canAccess(): bool
    {
        return (bool) auth()->user()?->can('manage-settings');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Company identity')
                    ->description('The name and logo employees see throughout the workspace.')
                    ->icon('heroicon-o-building-office-2')
                    ->schema([
                        TextInput::make('company_name')->label('Company name')->required()->maxLength(255),
                        FileUpload::make('company_logo')->label('Company logo')->disk('public')->directory('company')->image()->maxSize(2048),
                    ])
                    ->columns(2),
                Section::make('Brand appearance')
                    ->description('Set the primary and secondary colours used by the product interface.')
                    ->icon('heroicon-o-swatch')
                    ->schema([
                        ColorPicker::make('primary_color')->label('Primary colour')->required(),
                        ColorPicker::make('secondary_color')->label('Secondary colour')->required(),
                    ])
                    ->columns(2),
                Section::make('Working hours')
                    ->description('Define the operating window used by attendance and lateness rules.')
                    ->icon('heroicon-o-clock')
                    ->schema([
                        Select::make('timezone')->label('Timezone')->required()->searchable()->options(array_combine(\DateTimeZone::listIdentifiers(), \DateTimeZone::listIdentifiers())),
                        TimePicker::make('work_start_time')->label('Work starts')->required()->seconds(false),
                        TimePicker::make('late_after_time')->label('Late after')->required()->seconds(false),
                        TimePicker::make('work_end_time')->label('Work ends')->required()->seconds(false),
                    ])
                    ->columns(2),
                Section::make('Task defaults')
                    ->description('Control when upcoming task deadlines are highlighted to users.')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->schema([
                        TextInput::make('task_due_soon_hours')
                            ->label('Due soon window')
                            ->helperText('Tasks inside this many hours of their deadline are considered due soon.')
                            ->suffix('hours')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(168)
                            ->required(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [Action::make('save')->label('Save settings')->submit('save')];
    }

    public function save(): void
    {
        Setting::current()->update($this->form->getState());

        Notification::make()->title('Company settings saved')->success()->send();
    }
}
