<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\Request;

class ContractorController extends Controller
{
    public function index()
    {
        $contractors = Contractor::all();
        return view('contractors.index', compact('contractors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'spesialisasi'    => 'nullable|string|max:255',
            'kontak'          => 'nullable|string|max:50',
        ]);

        Contractor::create([
            'nama_perusahaan' => $request->nama_perusahaan,
            'spesialisasi'    => $request->spesialisasi,
            'kontak'          => $request->kontak,
            'status'          => 'Aktif',
        ]);

        return redirect()->route('contractors.index')->with('success', 'Mitra Kontraktor berhasil ditambahkan!');
    }

    public function destroy(Contractor $contractor)
    {
        $contractor->delete();
        return redirect()->route('contractors.index')->with('success', 'Data Mitra berhasil dihapus!');
    }
}