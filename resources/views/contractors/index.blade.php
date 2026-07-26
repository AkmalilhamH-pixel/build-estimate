<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitra Kontraktor - Build Estimate</title>
    <!-- Tailwind CSS v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">
        <!-- 1. SIDEBAR PANEL -->
        @include('layouts.sidebar')

        <!-- 2. MAIN CONTENT AREA -->
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-6xl mx-auto space-y-6">

                <!-- NOTIFIKASI SUKSES -->
                @if(session('success'))
                    <div class="bg-green-50 text-green-700 p-3 rounded-xl border border-green-200 font-medium text-sm shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- JUDUL HALAMAN -->
                <div>
                    <h2 class="text-xl font-black text-gray-900 tracking-tight">Data Mitra Kontraktor</h2>
                    <p class="text-xs text-gray-400 font-semibold mt-0.5">Kelola daftar vendor dan pelaksana proyek konstruksi</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    
                    <!-- FORM TAMBAH MITRA -->
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200/80">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-wider mb-4">Tambah Mitra Baru</h3>
                        <form action="{{ route('contractors.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama Perusahaan / Tim <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_perusahaan" placeholder="Contoh: CV. Bangun Utama" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500 font-medium" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Spesialisasi</label>
                                <input type="text" name="spesialisasi" placeholder="Contoh: Struktur & Beton" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500 font-medium">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Kontak (WA/Telp)</label>
                                <input type="text" name="kontak" placeholder="Contoh: 081234567890" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500 font-medium">
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-xl font-bold text-sm hover:bg-blue-700 transition shadow-md shadow-blue-600/10 cursor-pointer">
                                Simpan Mitra
                            </button>
                        </form>
                    </div>

                    <!-- TABEL DATABASE MITRA -->
                    <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 uppercase text-[10px] font-bold tracking-wider border-b border-gray-200">
                                    <th class="p-4 w-12 text-center">No</th>
                                    <th class="p-4">Nama Perusahaan</th>
                                    <th class="p-4">Spesialisasi</th>
                                    <th class="p-4">Kontak</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                                @forelse($contractors as $index => $contractor)
                                    <tr class="hover:bg-gray-50/40 transition">
                                        <td class="p-4 text-center text-gray-400 font-semibold">{{ $index + 1 }}</td>
                                        <td class="p-4 font-bold text-gray-900">{{ $contractor->nama_perusahaan }}</td>
                                        <td class="p-4 text-xs font-medium text-gray-600">{{ $contractor->spesialisasi ?? '-' }}</td>
                                        <td class="p-4 text-xs font-bold text-blue-600">{{ $contractor->kontak ?? '-' }}</td>
                                        <td class="p-4 text-center">
                                            <form action="{{ route('contractors.destroy', $contractor->id) }}" method="POST" onsubmit="return confirm('Hapus mitra ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-wider cursor-pointer">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-12 text-center text-gray-400 italic bg-gray-50/10">
                                            Belum ada data mitra terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</body>
</html>