<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Carbon;

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

    /**
     * @return Builder
     */
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

    /**
     * Query for published assignments (in window time)
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_up', '<=', now())
            ->where('published_down', '>=', now());
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeUntilNow(Builder $query): Builder
    {
        return $query->where('published_up', '<=', now());
    }

    /**
     * @param Builder $query
     * @param Carbon $from
     * @param Carbon|null $to
     * @return Builder
     */
    public function scopeRange(Builder $query, Carbon $from, Carbon $to = null): Builder
    {
        $to = $to ?? now();
        return $query->where('published_up', '>=', $from->format('Y-m-d H:i:s'))
            ->where('published_down', '<=', $to->format('Y-m-d H:i:s'));
    }

    /**
     * Query user's assignments
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('course', function ($query) use ($user) {
            $query->whereHas('attendants', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        });
    }
}
