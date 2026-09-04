<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends Model
{
    use LogsActivity;

    protected $fillable = [
        'company_name', 'company_logo', 'primary_color', 'secondary_color',
        'timezone', 'work_start_time', 'late_after_time', 'work_end_time',
        'task_due_soon_hours',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('settings')
            ->logOnly($this->fillable)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public static function current(): static
    {
        return static::query()->firstOrCreate([], [
            'primary_color' => '#2563EB',
            'secondary_color' => '#0F172A',
            'timezone' => config('app.timezone'),
            'work_start_time' => '08:00:00',
            'late_after_time' => '08:15:00',
            'work_end_time' => '17:00:00',
            'task_due_soon_hours' => 24,
        ]);
    }
}
