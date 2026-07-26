<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateItem extends Model
{
    use HasFactory;

    protected $fillable = ['estimate_id', 'nama_item', 'kuantitas', 'satuan', 'harga_satuan'];

    // Relasi Kebalikan: Item ini dimiliki oleh sebuah Estimasi Proyek
    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }
}