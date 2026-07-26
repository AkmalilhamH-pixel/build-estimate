<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Proyek Baru - Build Estimate</title>
    <!-- Tailwind CSS v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">

        <!-- SIDEBAR PANEL -->
        @include('layouts.sidebar')

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-3xl mx-auto space-y-6">

                <!-- Header Halaman -->
                <div class="flex items-center gap-4 mb-6">
                    <a href="{{ route('estimates.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-300 text-gray-500 hover:text-gray-900 hover:bg-gray-50 shadow-sm transition">
                        <span class="font-bold">←</span>
                    </a>
                    <div>
                        <h2 class="text-xl font-black text-gray-900 tracking-tight">Tambah Proyek Konstruksi</h2>
                        <p class="text-xs text-gray-400 font-semibold mt-0.5">Isi detail perencanaan dan relasikan dengan klien</p>
                    </div>
                </div>

                <!-- FORM TAMBAH PROYEK -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200/80">
                    <form action="{{ route('estimates.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Nama Proyek -->
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama / Judul Proyek <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_proyek" placeholder="Contoh: Pembangunan Rumah Tinggal Tipe 45" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-medium transition" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Dropdown Klien -->
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Pemilik / Klien <span class="text-red-500">*</span></label>
                                <select name="client_id" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-medium transition bg-white" required>
                                    <option value="" disabled selected>-- Pilih Klien --</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->nama_klien }}</option>
                                    @endforeach
                                </select>
                                <p class="text-[10px] text-gray-400 mt-1">Belum ada? Tambah dulu di menu Data Klien.</p>
                            </div>

                            <!-- Dropdown Kontraktor -->
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Mitra Kontraktor</label>
                                <select name="contractor_id" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-medium transition bg-white">
                                    <option value="" selected>-- Belum Ditentukan (Kosongkan jika belum ada) --</option>
                                    {{-- Menggunakan if isset agar tidak error jika Anda belum membuat tabel kontraktor --}}
                                    @if(isset($contractors) && count($contractors) > 0)
                                        @foreach($contractors as $contractor)
                                            <option value="{{ $contractor->id }}">{{ $contractor->nama_perusahaan }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Luas Bangunan -->
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Luas Bangunan (m²) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="luas_bangunan" placeholder="0" class="w-full text-sm border border-gray-300 p-2.5 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-medium transition" required>
                                    <span class="absolute right-3 top-2.5 text-sm text-gray-400 font-bold">m²</span>
                                </div>
                            </div>

                            <!-- Target Anggaran -->
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Target Anggaran / Pagu (Rp) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2.5 text-sm text-gray-500 font-bold">Rp</span>
                                    <input type="number" name="estimasi_biaya" placeholder="0" class="w-full text-sm border border-gray-300 p-2.5 pl-9 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-medium transition" required>
                                </div>
                            </div>
                        </div>

                        <!-- Status Proyek -->
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Status Proyek <span class="text-red-500">*</span></label>
                            <select name="status_proyek" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-medium transition bg-white" required>
                                <option value="Draft">Draft (Perencanaan Awal)</option>
                                <option value="Negosiasi">Tahap Negosiasi</option>
                                <option value="Disetujui / Berjalan">Disetujui / Proyek Berjalan</option>
                            </select>
                        </div>

                        <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                            <a href="{{ route('estimates.index') }}" class="px-5 py-2.5 rounded-xl font-bold text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 transition">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-blue-700 transition shadow-md shadow-blue-600/10 cursor-pointer flex items-center gap-2">
                                💾 Simpan Data Proyek
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>

    </div>

</body>
</html>