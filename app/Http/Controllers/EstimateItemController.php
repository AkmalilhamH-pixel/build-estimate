<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use App\Models\EstimateItem;
use Illuminate\Http\Request;

class EstimateItemController extends Controller
{
    // Menyimpan Item Baru ke dalam Proyek RAB
    public function store(Request $request, $estimateId)
    {
        $request->validate([
            'nama_item' => 'required',
            'kuantitas' => 'required|numeric',
            'satuan' => 'required',
            'harga_satuan' => 'required|numeric',
        ]);

        // 1. Simpan item ke database
        EstimateItem::create([
            'estimate_id' => $estimateId,
            'nama_item' => $request->nama_item,
            'kuantitas' => $request->kuantitas,
            'satuan' => $request->satuan,
            'harga_satuan' => $request->harga_satuan,
        ]);

        // 2. OTOMATISASI: Hitung total biaya baru dari semua item lalu update tabel utama
        $this->updateParentCost($estimateId);

        return redirect()->back()->with('success', 'Item material/pekerjaan berhasil ditambahkan!');
    }

    // Menghapus Item dari Proyek
    public function destroy($id)
    {
        $item = EstimateItem::findOrFail($id);
        $estimateId = $item->estimate_id;
        
        $item->delete();

        // OTOMATISASI: Hitung ulang setelah ada data yang dihapus
        $this->updateParentCost($estimateId);

        return redirect()->back()->with('success', 'Item berhasil dihapus dari daftar!');
    }

    // Fungsi pembantu untuk sinkronisasi total biaya ke tabel proyek utama
    private function updateParentCost($estimateId)
    {
        $estimate = Estimate::findOrFail($estimateId);
        
        // Rumus: Sum dari (kuantitas * harga_satuan) untuk semua item terkait
        $totalBiayaBaru = $estimate->items->sum(function($item) {
            return $item->kuantitas * $item->harga_satuan;
        });

        // Update nilai estimasi_biaya di tabel utama
        $estimate->update(['estimasi_biaya' => $totalBiayaBaru]);
    }
}