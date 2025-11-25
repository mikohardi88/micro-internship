<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Company;
use App\Models\ProjectApplication;
use App\Models\Placement;
use App\Models\User;
use App\Models\Skill;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'slug',
        'description',
        'skills_text',
        'duration_weeks',
        'status',
        'admin_notes',
        'approved_by',
        'approved_at',
        'max_applicants',
        'budget',
        'start_date',
        'end_date',
        'brief_path', // Kept for backward compatibility
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
        'budget' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(ProjectApplication::class);
    }

    public function placement()
    {
        return $this->hasOne(Placement::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'project_skill')->withPivot(['proficiency_level'])->withTimestamps();
    }
}
