<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_proyek', 
        'nama_klien', 
        'deskripsi', 
        'luas_bangunan', 
        'status_proyek', 
        'estimasi_biaya'
    ];

    /**
     * Relasi One-to-Many: Satu Proyek memiliki banyak Item RAB.
     * Menghubungkan model Estimate dengan model EstimateItem.
     */
    public function items()
    {
        return $this->hasMany(EstimateItem::class);
    }
}