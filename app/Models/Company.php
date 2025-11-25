<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Project;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'industry',
        'website',
        'logo_path',
        'address',
        'city',
        'province',
        'postal_code',
        'phone',
        'company_size',
        'founded_year',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'founded_year' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
