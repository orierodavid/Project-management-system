<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
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
                TextInput::make('company_name')->required()->maxLength(255),
                FileUpload::make('company_logo')->label('Company logo')->disk('public')->directory('company')->image()->maxSize(2048),
                ColorPicker::make('primary_color')->required(),
                ColorPicker::make('secondary_color')->required(),
                Select::make('timezone')->required()->searchable()->options(array_combine(\DateTimeZone::listIdentifiers(), \DateTimeZone::listIdentifiers())),
                TimePicker::make('work_start_time')->required()->seconds(false),
                TimePicker::make('late_after_time')->required()->seconds(false),
                TimePicker::make('work_end_time')->required()->seconds(false),
                TextInput::make('task_due_soon_hours')->numeric()->minValue(1)->maxValue(168)->required(),
            ])
            ->statePath('data')
            ->columns(2);
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
