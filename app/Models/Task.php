<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'department_id', 'branch_id', 'assigned_to',
        'assigned_by', 'priority', 'status', 'is_overdue', 'deadline', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'is_overdue' => 'boolean',
            'deadline' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function assignee(): BelongsTo { return $this->belongsTo(User::class, 'assigned_to'); }
    public function assigner(): BelongsTo { return $this->belongsTo(User::class, 'assigned_by'); }
    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function branch(): BelongsTo { return $this->belongsTo(Branch::class); }
    public function comments(): HasMany { return $this->hasMany(TaskComment::class); }
    public function attachments(): HasMany { return $this->hasMany(TaskAttachment::class); }
}
