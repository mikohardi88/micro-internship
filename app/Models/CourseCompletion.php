<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_name',
        'institution',
        'completion_date',
        'certificate_url',
        'skills_learned',
    ];

    protected $casts = [
        'completion_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
