<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\EstimateItemController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CostRecapController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\DesignController; 
use App\Http\Controllers\ConsultationController; // Import Controller Konsultasi

// ─── 1. RUTE UNTUK GUEST (PENGUNJUNG YANG BELUM LOGIN) ───
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// ─── 2. RUTE TERPROTEKSI (WAJIB LOGIN) ───
Route::middleware('auth')->group(function () {
    
    // Logout & Redirect Halaman Utama
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/', function () {
        return redirect()->route('estimates.index');
    });

    // Pengaturan Profil 
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // ─── B. RUTE KHUSUS ADMIN DIPINDAH KE ATAS AGAR TIDAK BENTROK ───
    Route::middleware('role:admin')->group(function () {
        
        // Operasi Tambah/Edit/Hapus Proyek (create harus dibaca sebelum {estimate})
        Route::get('estimates/create', [EstimateController::class, 'create'])->name('estimates.create');
        Route::post('estimates', [EstimateController::class, 'store'])->name('estimates.store');
        Route::get('estimates/{estimate}/edit', [EstimateController::class, 'edit'])->name('estimates.edit');
        Route::put('estimates/{estimate}', [EstimateController::class, 'update'])->name('estimates.update');
        Route::delete('estimates/{estimate}', [EstimateController::class, 'destroy'])->name('estimates.destroy');

        // Manajemen Item Pekerjaan RAB
        Route::post('estimates/{estimate}/items', [EstimateItemController::class, 'store'])->name('estimate_items.store');
        Route::delete('estimate_items/{item}', [EstimateItemController::class, 'destroy'])->name('estimate_items.destroy');

        // Manajemen Data Klien
        Route::resource('clients', ClientController::class)->only(['index', 'store', 'destroy']);

        // Manajemen Data Mitra Kontraktor
        Route::resource('contractors', ContractorController::class)->except(['create', 'show', 'edit', 'update']);
    });

    // ─── A. RUTE BERSAMA (ADMIN, KLIEN, KONTRAKTOR) ───
    Route::middleware('role:admin,klien,kontraktor')->group(function () {
        Route::get('estimates', [EstimateController::class, 'index'])->name('estimates.index');

        // Fitur Analisa Lahan (Ditaruh sebelum {estimate} agar tidak terbaca sebagai ID)
        Route::get('estimates/analisis-lahan', function () {
            return view('estimates.analisis-lahan');
        })->name('estimates.analisis-lahan');

        // Fitur Desain & Blueprint Arsitektur
        Route::get('designs', [DesignController::class, 'index'])->name('designs.index');

        // 💬 FITUR KONSULTASI (BARU)
        Route::get('consultations', [ConsultationController::class, 'index'])->name('consultations.index');
        Route::post('consultations', [ConsultationController::class, 'store'])->name('consultations.store');
        
        // Wildcard {estimate} ditaruh di bawah rute statis
        Route::get('estimates/{estimate}', [EstimateController::class, 'show'])->name('estimates.show');

        // Rekapitulasi Biaya
        Route::get('recap', [CostRecapController::class, 'index'])->name('recap.index');
        Route::get('recap/{id}', [CostRecapController::class, 'show'])->name('recap.show');
    });

});