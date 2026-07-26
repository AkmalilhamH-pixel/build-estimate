<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Tampilkan Semua Klien
    public function index()
    {
        $clients = Client::latest()->get();
        return view('clients.index', compact('clients'));
    }

    // Simpan Klien Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_klien' => 'required|string|max:255',
            'no_telp' => 'nullable|string',
            'email' => 'nullable|email',
            'alamat' => 'nullable|string',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Data klien berhasil ditambahkan!');
    }

    // Hapus Data Klien
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Data klien berhasil dihapus!');
    }
}