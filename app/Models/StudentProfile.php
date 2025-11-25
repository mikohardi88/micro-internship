<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'university',
        'major',
        'semester',
        'interests',
        'skills',
        'cv_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
