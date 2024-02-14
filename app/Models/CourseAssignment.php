<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'description',
        'max_submission',
        'published_up',
        'published_down',
    ];
    
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function testCases(): HasMany
    {
        return $this->hasMany(TestCase::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
}
