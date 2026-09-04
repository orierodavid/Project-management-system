<?php

namespace App\Filament\Pages;

use App\Exports\AttendanceExport;
use App\Models\AttendanceRecord;
use App\Models\Branch;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceReports extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Attendance Reports';

    protected static string $view = 'filament.pages.attendance-reports';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'from' => now()->startOfMonth()->toDateString(),
            'to' => now()->toDateString(),
        ]);
    }

    public static function canAccess(): bool
    {
        return (bool) auth()->user()?->can('view-reports');
    }

    public function form(Form $form): Form
    {
        $actor = auth()->user();
        $branchQuery = Branch::query()->orderBy('name');
        $userQuery = User::query()->where('status', 'active')->orderBy('name');

        if ($actor?->hasRole('Admin')) {
            $branchIds = $actor->branches()->pluck('branches.id');
            $branchQuery->whereIn('id', $branchIds);
            $userQuery->where(function (Builder $query) use ($branchIds): void {
                $query->whereIn('primary_branch_id', $branchIds)
                    ->orWhereHas('branches', fn (Builder $q) => $q->whereIn('branches.id', $branchIds));
            });
        }

        return $form->schema([
            DatePicker::make('from')->label('From')->required()->maxDate(fn () => $this->data['to'] ?? now()),
            DatePicker::make('to')->label('To')->required()->minDate(fn () => $this->data['from'] ?? now()->startOfMonth()),
            Select::make('branch_id')->label('Branch')->options($branchQuery->pluck('name', 'id'))->searchable()->preload(),
            Select::make('user_id')->label('Employee')->options($userQuery->pluck('name', 'id'))->searchable()->preload(),
            Select::make('status')->label('Status')->options([
                'on_time' => 'On Time',
                'late' => 'Late',
            ]),
        ])->statePath('data')->columns(5);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->action('export'),
        ];
    }

    public function getRecords(): array
    {
        return $this->query()->with(['user', 'branch'])->latest('clock_in_at')->get()->all();
    }

    public function export()
    {
        $records = $this->query()->with(['user', 'branch'])->latest('clock_in_at')->get();

        if ($records->isEmpty()) {
            Notification::make()->title('No attendance records found')->warning()->send();

            return null;
        }

        return Excel::download(new AttendanceExport($records), 'attendance-report-'.now()->format('Y-m-d-His').'.xlsx');
    }

    private function query(): Builder
    {
        $actor = auth()->user();
        $filters = $this->data;
        $query = AttendanceRecord::query();

        $from = ! empty($filters['from']) ? $filters['from'] : now()->startOfMonth()->toDateString();
        $to = ! empty($filters['to']) ? $filters['to'] : now()->toDateString();

        $query->whereBetween('clock_in_at', [$from.' 00:00:00', $to.' 23:59:59']);

        if ($actor?->hasRole('Admin')) {
            $branchIds = $actor->branches()->pluck('branches.id');
            $query->whereIn('branch_id', $branchIds);
        }

        if (! empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (! empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query;
    }
}
