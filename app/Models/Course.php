<?php

namespace App\Models;

use App\Enums\SaleModeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'start_date',
        'end_date',
        'sale_mode',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'sale_mode' => SaleModeEnum::class,
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(CourseAssignment::class);
    }

    public function attendants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_attendants')->using(CourseAttendant::class);
    }
}