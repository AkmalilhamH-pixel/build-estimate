<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostRecapController extends Controller
{
    // 1. Menampilkan Semua Proyek & Perbandingan Budget Kulit Luar
    public function index()
    {
        // Mengambil semua proyek dan menghitung total pengeluaran dari item secara real-time
        $estimates = Estimate::all()->map(function($estimate) {
            $estimate->total_rab = DB::table('estimate_items')
                ->where('estimate_id', $estimate->id)
                ->selectRaw('SUM(kuantitas * harga_satuan) as total')
                ->value('total') ?? 0;
            return $estimate;
        });

        return view('recap.index', compact('estimates'));
    }

    // 2. Menampilkan Cetak Lembar Rekapitulasi Per Kategori dari Satu Proyek Selected
    public function show($id)
    {
        $estimate = Estimate::findOrFail($id);

    // Mengelompokkan item berdasarkan nama_item / nama_material yang ada di tabel Anda
    // NOTE: Jika nama kolom di database Anda adalah 'nama_material', silakan ganti 'nama_item' di bawah menjadi 'nama_material'
    $rekap_items = DB::table('estimate_items')
        ->where('estimate_id', $id)
        ->select('nama_item', DB::raw('SUM(kuantitas * harga_satuan) as total_kategori'))
        ->groupBy('nama_item')
        ->get();

    $grand_total = $rekap_items->sum('total_kategori');

    return view('recap.show', compact('estimate', 'rekap_items', 'grand_total'));
    }
}