<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard RAB - Build Estimate</title>
    <!-- Tailwind CSS v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Google Font (Plus Jakarta Sans) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-100/70 font-sans antialiased transition-opacity duration-300 opacity-100" id="pageBody">

    <!-- ─── WRAPPER UTAMA (FLEXBOX) ─── -->
    <div class="flex min-h-screen">

        <!-- ─── 1. SIDEBAR PANEL ─── -->
        @include('layouts.sidebar')

        <!-- ─── 2. MAIN CONTENT AREA ─── -->
        <main class="flex-1 p-6 md:p-8 overflow-y-auto">
            <div class="max-w-7xl mx-auto space-y-6">

                <!-- NOTIFIKASI SUKSES -->
                @if(session('success'))
                    <div class="bg-emerald-50 text-emerald-700 p-4 rounded-2xl border border-emerald-200/80 font-semibold text-sm shadow-sm flex items-center gap-3 animate-fade-in">
                        <span class="text-base">✅</span>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                <!-- ─── KARTU UTAMA DASHBOARD ─── -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
                    
                    <!-- Header Kartu & Tombol Tambah -->
                    <div class="p-6 md:p-8 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Proyek Konstruksi</h2>
                            <p class="text-xs text-slate-400 font-semibold mt-1">Memuat seluruh data perencanaan pagu anggaran aktif</p>
                        </div>
                        
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('estimates.create') }}" id="btnAddProject" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-bold text-xs shadow-lg shadow-blue-600/20 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-2 cursor-pointer">
                                <span id="btnText">+ Tambah Proyek Baru</span>
                                <span id="btnSpinner" class="hidden animate-spin w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span>
                            </a>
                        @endif
                    </div>

                    <div class="p-6 md:p-8 space-y-6">

                        <!-- Control Table: Show Entries & Search Input -->
                        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 text-xs font-bold text-slate-500">
                            <div class="flex items-center gap-2">
                                <span>Show</span>
                                <select class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-700 font-semibold focus:outline-none focus:border-blue-500 focus:bg-white transition cursor-pointer">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select>
                                <span>entries</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <span>Search:</span>
                                <input type="text" placeholder="Cari proyek atau klien..." class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white transition w-full sm:w-64 font-medium">
                            </div>
                        </div>

                        <!-- ─── TABEL MODERN (MODERN CLEAN TABLE) ─── -->
                        <div class="overflow-x-auto rounded-2xl border border-slate-200/70">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/80 text-slate-400 uppercase text-[11px] font-black tracking-wider border-b border-slate-200/70">
                                        <th class="py-4 px-5 text-center w-12">No</th>
                                        <th class="py-4 px-5">Nama Proyek</th>
                                        <th class="py-4 px-5">Nama Klien</th>
                                        <th class="py-4 px-5 text-center">Luas</th>
                                        <th class="py-4 px-5 text-right">Target Anggaran (Pagu)</th>
                                        <th class="py-4 px-5 text-center">Status</th>
                                        <th class="py-4 px-5 text-center w-52">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-slate-700 text-sm divide-y divide-slate-100 font-medium">
                                    @forelse($estimates as $index => $est)
                                        <tr class="hover:bg-slate-50/70 transition-colors group">
                                            
                                            <!-- Nomor -->
                                            <td class="py-4 px-5 text-center text-slate-400 font-bold text-xs">
                                                {{ $index + 1 }}
                                            </td>

                                            <!-- Nama Proyek -->
                                            <td class="py-4 px-5 font-bold text-slate-900 group-hover:text-blue-600 transition">
                                                <a href="{{ route('estimates.show', $est->id) }}" class="hover:underline">
                                                    {{ $est->nama_proyek }}
                                                </a>
                                            </td>

                                            <!-- Nama Klien -->
                                            <td class="py-4 px-5 text-slate-600 font-semibold">
                                                {{ $est->nama_klien }}
                                            </td>

                                            <!-- Luas Bangunan -->
                                            <td class="py-4 px-5 text-center text-slate-600 font-bold text-xs">
                                                <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-lg">
                                                    {{ $est->luas_bangunan }} m²
                                                </span>
                                            </td>

                                            <!-- Target Anggaran -->
                                            <td class="py-4 px-5 text-right font-extrabold text-blue-600">
                                                Rp {{ number_format($est->estimasi_biaya, 0, ',', '.') }}
                                            </td>

                                            <!-- Status (Pill Badge Style) -->
                                            <td class="py-4 px-5 text-center">
                                                @php
                                                    $badgeStyle = match($est->status_proyek) {
                                                        'Draft' => 'bg-amber-50 text-amber-600 border-amber-200/60',
                                                        'Negosiasi' => 'bg-sky-50 text-sky-600 border-sky-200/60',
                                                        'Disetujui / Berjalan' => 'bg-emerald-50 text-emerald-600 border-emerald-200/60',
                                                        'Ditolak' => 'bg-rose-50 text-rose-600 border-rose-200/60',
                                                        default => 'bg-slate-100 text-slate-600 border-slate-200',
                                                    };
                                                @endphp
                                                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black border uppercase tracking-wider shadow-2xs {{ $badgeStyle }}">
                                                    {{ $est->status_proyek }}
                                                </span>
                                            </td>

                                            <!-- Tombol Aksi (Soft Modern Buttons) -->
                                            <td class="py-4 px-5">
                                                <div class="flex items-center justify-center gap-1.5">
                                                    
                                                    <!-- Rincian -->
                                                    <a href="{{ route('estimates.show', $est->id) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1 shadow-2xs" title="Lihat Rincian">
                                                        👁️ <span class="hidden sm:inline">Rincian</span>
                                                    </a>

                                                    @if(auth()->user()->isAdmin())
                                                        <!-- Edit -->
                                                        <a href="{{ route('estimates.edit', $est->id) }}" class="bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white px-3 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1 shadow-2xs" title="Edit Data">
                                                            ✏️ <span class="hidden sm:inline">Edit</span>
                                                        </a>

                                                        <!-- Hapus -->
                                                        <form action="{{ route('estimates.destroy', $est->id) }}" method="POST" id="deleteForm-{{ $est->id }}" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" onclick="confirmDelete('{{ $est->id }}')" class="bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white px-3 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1 shadow-2xs cursor-pointer" title="Hapus Data">
                                                                ❌ <span class="hidden sm:inline">Hapus</span>
                                                            </button>
                                                        </form>
                                                    @endif

                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-12 text-center text-slate-400 italic bg-slate-50/30">
                                                Belum ada data proyek terdaftar.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer Tabel / Pagination -->
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-xs font-semibold text-slate-500 pt-2">
                            <div>
                                Showing 1 to {{ count($estimates) }} of {{ count($estimates) }} entries
                            </div>
                            <div class="flex items-center gap-1">
                                <button class="px-3.5 py-2 border border-slate-200 rounded-xl bg-slate-50 text-slate-400 cursor-not-allowed font-bold" disabled>Previous</button>
                                <button class="px-3.5 py-2 rounded-xl bg-blue-600 text-white font-black shadow-md shadow-blue-600/20">1</button>
                                <button class="px-3.5 py-2 border border-slate-200 rounded-xl bg-slate-50 text-slate-400 cursor-not-allowed font-bold" disabled>Next</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </main>

    </div>

    <!-- ─── SCRIPT JAVASCRIPT UNTUK ANIMASI & KONFIRMASI ─── -->
    <script>
        // 1. Loading State pada Tombol Tambah
        const btnAddProject = document.getElementById('btnAddProject');
        if (btnAddProject) {
            btnAddProject.addEventListener('click', function() {
                const btnText = document.getElementById('btnText');
                const btnSpinner = document.getElementById('btnSpinner');
                
                btnText.textContent = 'Membuka Form...';
                btnSpinner.classList.remove('hidden');
                btnAddProject.classList.add('opacity-80', 'cursor-wait');
            });
        }

        // 2. Fungsi Konfirmasi Hapus Proyek
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus seluruh data proyek ini beserta rincian di dalamnya?')) {
                document.getElementById('deleteForm-' + id).submit();
            }
        }
    </script>

</body>
</html>