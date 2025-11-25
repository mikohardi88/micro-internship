<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Project;
use App\Models\User;
use App\Models\Deliverable;

class Placement extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'status',
        'start_date',
        'end_date',
        'supervisor_name',
        'supervisor_email',
        'supervisor_phone',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliverables()
    {
        return $this->hasMany(Deliverable::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
