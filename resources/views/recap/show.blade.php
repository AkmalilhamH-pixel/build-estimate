<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Rekapitulasi RAB - {{ $estimate->nama_proyek }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white; padding: 0; }
        }
    </style>
</head>
<body class="bg-gray-50 p-6 sm:p-12 text-gray-800">

    <div class="max-w-4xl mx-auto mb-6 flex justify-between items-center no-print bg-white p-4 rounded-xl shadow-sm border">
        <a href="{{ route('recap.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800">← Kembali ke Analisis</a>
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold text-xs hover:bg-blue-700 transition cursor-pointer">
            🖨️ Cetak / Simpan PDF
        </button>
    </div>

    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-2xl border border-gray-200 shadow-sm space-y-8">
        
        <div class="text-center border-b-2 border-gray-900 pb-5">
            <h1 class="text-2xl font-black uppercase tracking-wide text-gray-900">REKAPITULASI BIAYA</h1>
            <h2 class="text-md font-bold text-gray-700 uppercase mt-1">RENCANA ANGGARAN BIAYA (RAB) BANGUNAN</h2>
        </div>

        <div class="grid grid-cols-2 gap-4 text-xs">
            <div class="space-y-1">
                <p class="text-gray-400 font-medium">Nama Pekerjaan / Proyek :</p>
                <p class="font-black text-sm text-gray-900">{{ $estimate->nama_proyek }}</p>
                <p class="text-gray-400 font-medium pt-2">Pemilik / Klien :</p>
                <p class="font-bold text-gray-800">{{ $estimate->nama_klien }}</p>
            </div>
            <div class="space-y-1 text-right">
                <p class="text-gray-400 font-medium">Luas Bangunan :</p>
                <p class="font-bold text-gray-800">{{ $estimate->luas_bangunan }} m²</p>
                <p class="text-gray-400 font-medium pt-2">Tanggal Rekap :</p>
                <p class="font-bold text-gray-800">{{ date('d F Y') }}</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100 text-gray-800 uppercase text-xs font-bold border-b border-gray-300">
                        <th class="border border-gray-300 p-3 w-12 text-center">No</th>
                        <th class="border border-gray-300 p-3">Uraian / Kelompok Pekerjaan</th>
                        <th class="border border-gray-300 p-3 text-right w-48">Jumlah Biaya (Rp)</th>
                        <th class="border border-gray-300 p-3 text-center w-24">Bobot (%)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($rekap_items as $index => $item)
                        @php
                            // Rumus Matematika Bobot Persentase
                            $bobot = $grand_total > 0 ? ($item->total_kategori / $grand_total) * 100 : 0;
                        @endphp
                        <tr>
                            <td class="border border-gray-300 p-3 text-center font-medium">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 p-3 font-bold text-gray-900">{{ $item->kategori_pekerjaan ?? 'Pekerjaan Umum / Lainnya' }}</td>
                            <td class="border border-gray-300 p-3 text-right font-semibold">Rp {{ number_format($item->total_kategori, 0, ',', '.') }}</td>
                            <td class="border border-gray-300 p-3 text-center font-medium">{{ number_format($bobot, 2) }} %</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border border-gray-300 p-8 text-center text-gray-400 italic">Belum ada rincian item pekerjaan yang dimasukkan ke dalam proyek ini.</td>
                        </tr>
                    @endforelse
                    
                    <tr class="bg-gray-50 font-black text-gray-900">
                        <td colspan="2" class="border border-gray-300 p-4 text-right uppercase tracking-wider">Jumlah Total Anggaran (RAB)</td>
                        <td class="border border-gray-300 p-4 text-right text-base text-blue-600">Rp {{ number_format($grand_total, 0, ',', '.') }}</td>
                        <td class="border border-gray-300 p-4 text-center">100.00 %</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pt-12 flex justify-end">
            <div class="text-center w-48 text-xs space-y-16">
                <div>
                    <p class="text-gray-400 font-medium">Dibuat Oleh,</p>
                    <p class="font-bold text-gray-800 mt-1">Estimator Proyek</p>
                </div>
                <div class="border-b border-gray-400 w-full mx-auto"></div>
                <p class="font-bold text-gray-500 uppercase tracking-wider">Build Estimate System</p>
            </div>
        </div>

    </div>

</body>
</html>