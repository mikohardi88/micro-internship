<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'placement_id',
        'user_id',
        'certificate_number',
        'issued_at',
        'file_path',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function placement()
    {
        return $this->belongsTo(Placement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
