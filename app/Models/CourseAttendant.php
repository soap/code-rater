<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseAttendant extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'is_active',
        'is_completed',
        'completed_at',
        'started_at',
        'expired_at',
        'enrolled_at',
        'unenrolled_at',
        'last_accessed_at',
        'notes',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
