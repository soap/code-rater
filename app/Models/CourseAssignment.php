<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class CourseAssignment extends Model
{
    use HasFactory;
    use SortableTrait;

    protected $fillable = [
        'course_id',
        'name',
        'description',
        'ordering', // This is the column that will be used to sort the records 
        'max_submission',
        'published_up',
        'published_down',
    ];

    public $sortable = [
        'order_column_name' => 'ordering',
        'sort_when_creating' => true,
    ];

    public function buildSortQuery(): Builder
    {
        return static::query()->where('course_id', $this->course_id);    
    }

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

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_up', '<=', now())
            ->where('published_down', '>=', now());
    }
}
