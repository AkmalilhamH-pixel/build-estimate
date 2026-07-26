<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use App\Models\Client;      // WAJIB DITAMBAHKAN: Untuk memanggil data tabel Klien
use App\Models\Contractor;  // WAJIB DITAMBAHKAN: Untuk memanggil data tabel Kontraktor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class EstimateController extends Controller
{
    // Menampilkan semua data di dashboard utama
    public function index()
    {
        $estimates = Estimate::all();
        
        // Perintah hitung otomatis untuk Stat Cards
        $totalProyek = $estimates->count(); 
        $totalBiaya = $estimates->sum('estimasi_biaya'); 

        // Mengirimkan variabel hitungan ke halaman index
        return view('estimates.index', compact('estimates', 'totalProyek', 'totalBiaya'));
    }

    // Menampilkan halaman form tambah data dengan dukungan sinkronisasi Analisa Lahan
    public function create(Request $request)
    {
        // Mengambil seluruh data Klien dari database untuk dimasukkan ke opsi dropdown
        $clients = Client::all();
        
        // Cek apakah tabel kontraktor sudah dibuat. Jika belum, jadikan array kosong agar tidak error.
        $contractors = Schema::hasTable('contractors') ? Contractor::all() : [];

        // Tangkap parameter query dari halaman Analisa Lahan
        $defaultLuas = $request->query('luas', 0);
        $defaultAnggaran = $request->query('anggaran', 0);
        $defaultLokasi = $request->query('lokasi', '');

        // Lempar variabel ke halaman create
        return view('estimates.create', compact('clients', 'contractors', 'defaultLuas', 'defaultAnggaran', 'defaultLokasi'));
    }

    // Menyimpan data baru ke database
    public function store(Request $request)
    {
        // Validasi input disesuaikan dengan form create.blade.php yang baru
        $request->validate([
            'nama_proyek'    => 'required|string|max:255',
            'client_id'      => 'required',
            'contractor_id'  => 'nullable',
            'luas_bangunan'  => 'required|numeric',
            'status_proyek'  => 'required|string',
            'estimasi_biaya' => 'required|numeric',
        ]);

        // Cari data klien berdasarkan ID yang dipilih dari dropdown
        $client = Client::findOrFail($request->client_id);

        Estimate::create([
            'nama_proyek'    => $request->nama_proyek,
            'nama_klien'     => $client->nama_klien, // Menyimpan nama klien agar kompatibel dengan tabel lama
            'client_id'      => $request->client_id, // Simpan ID Klien
            'contractor_id'  => $request->contractor_id, // Simpan ID Kontraktor (Bisa kosong)
            'luas_bangunan'  => $request->luas_bangunan,
            'estimasi_biaya' => $request->estimasi_biaya,
            'status_proyek'  => $request->status_proyek,
            'total_rab'      => 0, // Default 0 saat baru dibuat
        ]);

        return redirect()->route('estimates.index')->with('success', 'Proyek berhasil ditambahkan!');
    }

    /**
     * 🔍 BARU: Menampilkan halaman rincian / detail item RAB proyek
     * Menggunakan Route Model Binding agar otomatis mencari data proyek
     */
    public function show(Estimate $estimate)
    {
        $estimate->load('items');
    
        return view('estimates.show', compact('estimate'));
    }

    /**
     * ✏️ PERBAIKAN: Menampilkan halaman form edit data
     * Sudah diperbaiki agar mengarah ke form edit yang benar beserta dropdown klien
     */
    public function edit(Estimate $estimate)
    {
        $clients = Client::all();
        $contractors = Schema::hasTable('contractors') ? Contractor::all() : [];

        return view('estimates.edit', compact('estimate', 'clients', 'contractors'));
    }

    // Memperbarui data di database
    public function update(Request $request, Estimate $estimate)
    {
        // Validasi disamakan dengan fungsi store
        $request->validate([
            'nama_proyek'    => 'required|string|max:255',
            'client_id'      => 'required',
            'contractor_id'  => 'nullable',
            'luas_bangunan'  => 'required|numeric',
            'status_proyek'  => 'required|string',
            'estimasi_biaya' => 'required|numeric',
        ]);

        $client = Client::findOrFail($request->client_id);

        $estimate->update([
            'nama_proyek'    => $request->nama_proyek,
            'nama_klien'     => $client->nama_klien,
            'client_id'      => $request->client_id,
            'contractor_id'  => $request->contractor_id,
            'luas_bangunan'  => $request->luas_bangunan,
            'estimasi_biaya' => $request->estimasi_biaya,
            'status_proyek'  => $request->status_proyek,
        ]);

        return redirect()->route('estimates.index')->with('success', 'Proyek berhasil diperbarui!');
    }

    // Menghapus data dari database
    public function destroy(Estimate $estimate)
    {
        $estimate->delete();
        return redirect()->route('estimates.index')->with('success', 'Data berhasil dihapus!');
    }
}