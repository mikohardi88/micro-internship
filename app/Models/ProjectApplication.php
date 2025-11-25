<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Project;
use App\Models\User;

class ProjectApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'cover_letter',
        'status',
        'applied_at',
        'decided_at',
        'decision_notes',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'decided_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
