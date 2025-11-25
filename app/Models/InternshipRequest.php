<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Company;

class InternshipRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'company_id',
        'title',
        'description',
        'skills_needed',
        'duration_weeks',
        'status',
        'additional_notes',
    ];

    protected $casts = [
        'skills_needed' => 'array', // untuk menyimpan array skill yang dibutuhkan
        'duration_weeks' => 'integer',
    ];

    protected $attributes = [
        'status' => 'pending', // status default
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}