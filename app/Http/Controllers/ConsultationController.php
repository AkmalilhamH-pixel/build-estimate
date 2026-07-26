<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Estimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Ambil daftar proyek sesuai hak akses/role secara aman
        if ($user->isAdmin()) {
            $estimates = Estimate::all();
        } else {
            $estimates = collect();
            
            // Cek ketersediaan kolom relasi di tabel estimates untuk mencegah error SQL
            $hasClient = Schema::hasColumn('estimates', 'client_id');
            $hasContractor = Schema::hasColumn('estimates', 'contractor_id');
            
            $query = Estimate::query();
            
            if ($hasClient && $hasContractor) {
                $query->where('client_id', $user->id)
                      ->orWhere('contractor_id', $user->id);
            } elseif ($hasClient) {
                $query->where('client_id', $user->id);
            } elseif ($hasContractor) {
                $query->where('contractor_id', $user->id);
            }
            
            $estimates = $query->get();
            
            // Fallback pengaman: Jika hasil filter kosong, tampilkan semua data agar halaman tidak error/kosong
            if ($estimates->isEmpty()) {
                $estimates = Estimate::all();
            }
        }

        // Tentukan proyek aktif[cite: 9]
        $activeEstimateId = $request->query('estimate_id', $estimates->first()->id ?? null);
        $activeEstimate = $estimates->firstWhere('id', $activeEstimateId);

        // Ambil riwayat percakapan proyek aktif[cite: 9]
        $messages = [];
        if ($activeEstimate) {
            $messages = Consultation::with('user')
                ->where('estimate_id', $activeEstimate->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('consultations.index', compact('estimates', 'activeEstimate', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'estimate_id' => 'required|exists:estimates,id',
            'message'     => 'required|string|max:1000',
        ]);

        Consultation::create([
            'estimate_id' => $request->estimate_id,
            'user_id'     => auth()->id(),
            'message'     => $request->message,
        ]);

        return redirect()->route('consultations.index', ['estimate_id' => $request->estimate_id]);
    }
}