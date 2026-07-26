<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Biaya - Build Estimate</title>
    <!-- Tailwind CSS v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- ─── WRAPPER UTAMA (FLEXBOX) ─── -->
    <div class="flex min-h-screen">

        <!-- ─── 1. SIDEBAR PANEL ─── -->
        @include('layouts.sidebar')

        <!-- ─── 2. MAIN CONTENT AREA ─── -->
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-5xl mx-auto space-y-6">

                <!-- JUDUL HALAMAN -->
                <div>
                    <h2 class="text-xl font-black text-gray-900 tracking-tight">Analisis & Rekapitulasi Biaya</h2>
                    <p class="text-xs text-gray-400 font-semibold mt-0.5">Pantau perbandingan anggaran pagu target vs realisasi total item RAB</p>
                </div>

                <!-- KONTEN KARTU REKAPITULASI -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($estimates as $est)
                        @php
                            $is_over = $est->total_rab > $est->estimasi_biaya;
                            $selisih = abs($est->estimasi_biaya - $est->total_rab);
                        @endphp
                        <div class="bg-white border rounded-2xl p-5 shadow-sm space-y-4 flex flex-col justify-between {{ $is_over ? 'border-red-200 bg-red-50/10' : 'border-gray-200' }}">
                            <div>
                                <div class="flex justify-between items-start">
                                    <h3 class="text-base font-black text-gray-900 leading-tight">{{ $est->nama_proyek }}</h3>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase border {{ $is_over ? 'bg-red-100 text-red-700 border-red-200' : 'bg-green-100 text-green-700 border-green-200' }}">
                                        {{ $is_over ? 'Over Budget' : 'Budget Aman' }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-400 mt-0.5">Klien: <span class="font-bold text-gray-600">{{ $est->nama_klien }}</span></p>
                                
                                <div class="grid grid-cols-2 gap-2 pt-4">
                                    <div class="p-2.5 bg-gray-50 rounded-xl border border-gray-100">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase">Target Pagu</p>
                                        <p class="text-sm font-black text-gray-800">Rp {{ number_format($est->estimasi_biaya, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="p-2.5 bg-gray-50 rounded-xl border border-gray-100">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase">Total RAB Item</p>
                                        <p class="text-sm font-black text-blue-600">Rp {{ number_format($est->total_rab, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2 border-t border-gray-100 flex items-center justify-between text-xs">
                                <span class="{{ $is_over ? 'text-red-600' : 'text-gray-500' }} font-medium">
                                    {{ $is_over ? 'Minus Selisih: ' : 'Sisa Alokasi: ' }} <b>Rp {{ number_format($selisih, 0, ',', '.') }}</b>
                                </span>
                                <a href="{{ route('recap.show', $est->id) }}" class="bg-slate-900 text-white px-3 py-1.5 rounded-lg font-bold hover:bg-blue-600 transition flex items-center gap-1">
                                    Buka Lembar Rekap ➔
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center p-12 text-gray-400 italic bg-white border border-dashed border-gray-200 rounded-2xl">
                            Belum ada proyek aktif untuk direkap biayanya.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

    </div>

</body>
</html>