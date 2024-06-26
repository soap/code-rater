<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Collection;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasPanelShield;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile_photo_url;
    }

    public function getNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getFullNameAttribute(): string
    {
        return $this->getNameAttribute();
    }

   /**
     * Used in filamnet resource to display user's roles.
     */
    public function getRoleNamesAttribute(): string
    {
        return $this->roles->pluck('name')->join(',');
    }
    
    public function courses():BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_attendants')
            ->withPivot([
                'is_active', 'is_completed', 'completed_at', 
                'started_at', 'expired_at', 
                'enrolled_at', 'unenrolled_at', 'last_accessed_at', 'notes'      
            ])
            ->using(CourseAttendant::class);
    }

    /**
     * Get all course assignments for the user.
     * @todo: This method should return Eloquent relationship.
     */

    public function getCourseAssignments(): Collection
    {
        $courseIds = $this->courses->pluck('id');
        
        return CourseAssignment::whereIn('course_id', $courseIds)
            ->with('course')
            ->get();
    }
}
