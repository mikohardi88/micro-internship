<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'role',
        'profile_photo_path',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'date_of_birth',
        'bio',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
        ];
    }

    // Relations
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(ProjectApplication::class);
    }

    public function placements()
    {
        return $this->hasMany(Placement::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skill')->withPivot(['proficiency_level'])->withTimestamps();
    }

    public function courseCompletions()
    {
        return $this->hasMany(CourseCompletion::class);
    }

    public function portfolioItems()
    {
        return $this->hasMany(PortfolioItem::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }
}
