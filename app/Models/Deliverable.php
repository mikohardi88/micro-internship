<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Placement;
use App\Models\User;

class Deliverable extends Model
{
    use HasFactory;

    protected $fillable = [
        'placement_id',
        'title',
        'description',
        'file_path',
        'status',
        'submitted_at',
        'reviewed_at',
        'feedback',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function placement()
    {
        return $this->belongsTo(Placement::class);
    }
}
