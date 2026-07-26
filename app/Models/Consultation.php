<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'estimate_id',
        'user_id',
        'message',
    ];

    // Relasi ke User (Pengirim Pesan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Estimate (Proyek)
    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }
}