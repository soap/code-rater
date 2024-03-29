<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AssignmentSubmission extends Model
{
    use HasFactory;

    public function assignment()
    {
        return $this->belongsTo(CourseAssignment::class);
    }

    public function scopeUser(Builder $query, User $user): Builder
    {
        return $query->where('user_id', $user->id);
    }
}
