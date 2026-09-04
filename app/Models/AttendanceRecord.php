<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'branch_id', 'clock_in_at', 'clock_in_lat', 'clock_in_lng',
        'clock_in_accuracy', 'clock_in_distance_meters', 'clock_out_at',
        'clock_out_lat', 'clock_out_lng', 'clock_out_accuracy',
        'clock_out_distance_meters', 'status', 'late_minutes',
    ];

    protected function casts(): array
    {
        return ['clock_in_at' => 'datetime', 'clock_out_at' => 'datetime'];
    }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function branch(): BelongsTo { return $this->belongsTo(Branch::class); }
}
