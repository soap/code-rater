<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\TestTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Spatie\EloquentSortable\SortableTrait;

class TestCase extends Model
{
    use HasFactory;
    use SortableTrait;

    protected $fillable = [
        'course_assignment_id', // This is the foreign key to the course assignment
        'name',
        'test_type_id',
        'command',
        'ordering',
        'description',
        'input',
        'output'    
    ];

    public $sortable = [
        'order_column_name' => 'ordering',
        'sort_when_creating' => true,
    ];

    protected $casts = [
        'test_type_id' => TestTypeEnum::class,
    ];

    public function buildSortQuery(): Builder
    {
        return static::query()->where('course_assignment_id', $this->course_assignment_id);
    }

    public function courseAssignment(): BelongsTo
    {
        return $this->belongsTo(CourseAssignment::class);
    }
}
