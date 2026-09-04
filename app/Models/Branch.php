<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\ValidationException;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Branch extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name', 'address', 'latitude', 'longitude', 'radius_meters', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'radius_meters' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('branches')
            ->logOnly($this->fillable)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function booted(): void
    {
        static::saving(function (Branch $branch): void {
            if ($branch->radius_meters < 1 || $branch->radius_meters > 50000) {
                throw ValidationException::withMessages([
                    'radius_meters' => 'The geofence radius must be between 1 and 50,000 metres.',
                ]);
            }

            if ($branch->is_active && (float) $branch->latitude === 0.0 && (float) $branch->longitude === 0.0) {
                throw ValidationException::withMessages([
                    'latitude' => 'An active branch must have real GPS coordinates. 0,0 is not a valid configured workplace location.',
                ]);
            }
        });
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
