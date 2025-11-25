<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skill')->withPivot(['proficiency_level'])->withTimestamps();
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_skill')->withPivot(['proficiency_level'])->withTimestamps();
    }
}
