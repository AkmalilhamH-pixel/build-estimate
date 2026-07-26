<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rincian RAB Proyek - Build Estimate</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto space-y-6">

        <div class="flex items-center justify-between bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center gap-4">
                <a href="{{ route('estimates.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 text-sm font-bold transition border border-gray-200 flex items-center gap-1">
                    ← Kembali
                </a>
                <div>
                    <h1 class="text-xl font-black text-gray-900">Breakdown Rincian RAB</h1>
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Manajemen Item Pekerjaan & Material Konstruksi</p>
                </div>
            </div>
            
            @php
                $badgeClass = match($estimate->status_proyek) {
                    'Draft' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                    'Negosiasi' => 'bg-blue-100 text-blue-700 border-blue-200',
                    'Disetujui / Berjalan' => 'bg-green-100 text-green-700 border-green-200',
                    'Ditolak' => 'bg-red-100 text-red-700 border-red-200',
                    default => 'bg-gray-100 text-gray-700 border-gray-200',
                };
            @endphp
            <span class="px-4 py-1.5 rounded-full text-xs font-black border uppercase tracking-wider {{ $badgeClass }}">
                {{ $estimate->status_proyek }}
            </span>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="border-b md:border-b-0 md:border-r border-gray-100 pb-4 md:pb-0 md:pr-4">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Nama Proyek Utama</p>
                <p class="text-lg font-black text-gray-900 mt-1">{{ $estimate->nama_proyek }}</p>
            </div>
            <div class="border-b md:border-b-0 md:border-r border-gray-100 pb-4 md:pb-0 md:pr-4">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Nama Klien / Pemilik</p>
                <p class="text-base font-bold text-gray-700 mt-1">{{ $estimate->nama_klien }}</p>
            </div>
            <div class="border-b md:border-b-0 md:border-r border-gray-100 pb-4 md:pb-0 md:pr-4">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Luas Bangunan</p>
                <p class="text-base font-bold text-gray-700 mt-1">{{ $estimate->luas_bangunan }} m²</p>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Target Pagu Anggaran</p>
                <p class="text-lg font-black text-blue-600 mt-1">Rp {{ number_format($estimate->estimasi_biaya, 0, ',', '.') }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 p-3 rounded-lg border border-green-200 font-medium text-sm shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 p-5 rounded-xl shadow-sm">
            <h3 class="text-xs font-black text-gray-800 uppercase tracking-wider mb-4 flex items-center gap-1">
                <span class="bg-blue-600 text-white w-5 h-5 flex items-center justify-center rounded-full text-[10px] font-bold">+</span>
                Tambah Komponen Pekerjaan / Material Manual
            </h3>
            
            <form action="{{ route('estimate_items.store', $estimate->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                @csrf
                
                <div class="md:col-span-4">
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Nama Material / Item</label>
                    <input type="text" name="nama_item" placeholder="Contoh: Pasir Pasang / Batu Bata" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500 font-medium" required>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-600 tracking-wide uppercase mb-1">Volume (Kuantitas)</label>
                    <input type="number" step="any" name="kuantitas" placeholder="Contoh: 15" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500 font-medium" required>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-600 tracking-wide uppercase mb-1">Satuan</label>
                    <input type="text" name="satuan" placeholder="m3 / Sak / Pcs" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500 font-medium" required>
                </div>
                
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-gray-600 tracking-wide uppercase mb-1">Harga Satuan (Rp)</label>
                    <input type="number" name="harga_satuan" placeholder="Angka saja" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500 font-medium" required>
                </div>
                
                <div class="md:col-span-1">
                    <button type="submit" class="w-full bg-blue-600 text-white h-[41px] rounded-lg font-bold text-sm hover:bg-blue-700 transition shadow-sm flex items-center justify-center">
                        Tambah
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="bg-gray-50/70 p-4 border-b border-gray-200">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Daftar Komponen Anggaran Riil</h3>
            </div>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase text-[11px] font-bold tracking-wider border-b border-gray-200">
                        <th class="p-4 w-12 text-center">No</th>
                        <th class="p-4">Deskripsi Komponen Pekerjaan / Material</th>
                        <th class="p-4 text-center">Volume</th>
                        <th class="p-4 text-center">Satuan</th>
                        <th class="p-4 text-right">Harga Satuan</th>
                        <th class="p-4 text-right">Total Biaya</th>
                        <th class="p-4 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @php $grandTotalRiil = 0; @endphp
                    @forelse($estimate->items as $index => $subItem)
                        @php 
                            $totalHargaItem = $subItem->kuantitas * $subItem->harga_satuan; 
                            $grandTotalRiil += $totalHargaItem;
                        @endphp
                        <tr class="hover:bg-gray-50/80 transition border-b border-gray-100">
                            <td class="p-4 text-center text-gray-400 font-semibold">{{ $index + 1 }}</td>
                            <td class="p-4 font-bold text-gray-900">{{ $subItem->nama_item }}</td>
                            <td class="p-4 text-center font-semibold text-gray-800">{{ $subItem->kuantitas }}</td>
                            <td class="p-4 text-center">
                                <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-0.5 rounded-md font-bold">{{ $subItem->satuan }}</span>
                            </td>
                            <td class="p-4 text-right font-medium text-gray-600">Rp {{ number_format($subItem->harga_satuan, 0, ',', '.') }}</td>
                            <td class="p-4 text-right font-bold text-gray-900">Rp {{ number_format($totalHargaItem, 0, ',', '.') }}</td>
                            <td class="p-4 text-center">
                                <form action="{{ route('estimate_items.destroy', $subItem->id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari RAB?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-wider">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-gray-400 italic bg-gray-50/20">Belum ada rincian material yang diinput. Silakan gunakan form di atas untuk memasukkan pengeluaran riil.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="bg-blue-50/50 font-bold border-t-2 border-blue-200">
                        <td colspan="5" class="p-4 text-right text-sm font-black text-blue-900 uppercase tracking-wide">Total Pengeluaran Riil (Akumulasi RAB):</td>
                        <td class="p-4 text-right text-base font-black text-blue-700">Rp {{ number_format($grandTotalRiil, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
    </div>
</body>
</html>