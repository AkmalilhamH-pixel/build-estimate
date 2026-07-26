<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desain & Blueprint - Build Estimate</title>
    <!-- Tailwind CSS v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100/70 font-sans antialiased">

    <div class="flex min-h-screen">

        <!-- Sidebar Navigation -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-8 overflow-y-auto">
            <div class="max-w-6xl mx-auto space-y-6">

                <!-- Header Halaman -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Desain & Blueprint Arsitektur</h1>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Kelola berkas denah 2D, konsep visual 3D, dan gambar kerja proyek</p>
                    </div>
                    
                    <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-3 rounded-2xl shadow-lg shadow-blue-600/20 transition cursor-pointer flex items-center gap-2">
                        <span>📤 Upload Desain Baru</span>
                    </button>
                </div>

                <!-- Filter Kategori & Proyek -->
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200/80 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0">
                        <button class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold">Semua Desain</button>
                        <button class="px-4 py-2 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-xl text-xs font-semibold">Denah 2D (CAD)</button>
                        <button class="px-4 py-2 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-xl text-xs font-semibold">Render 3D</button>
                        <button class="px-4 py-2 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-xl text-xs font-semibold">Detail M.E.P</button>
                    </div>

                    <div class="w-full sm:w-auto">
                        <select class="w-full text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:border-blue-600">
                            <option value="">-- Pilih Proyek --</option>
                            @foreach($estimates as $estimate)
                                <option value="{{ $estimate->id }}">{{ $estimate->nama_proyek }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Grid Galeri Desain -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Sample Card Desain 1 -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200/80 group hover:shadow-md transition">
                        <div class="relative h-48 bg-slate-200 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80" alt="3D Render" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <span class="absolute top-3 left-3 bg-blue-600 text-white text-[10px] font-black uppercase px-2.5 py-1 rounded-lg">Render 3D</span>
                        </div>
                        <div class="p-5 space-y-3">
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition">Konsep Fasad Eksterior Minimalis</h3>
                                <p class="text-[11px] font-medium text-slate-400 mt-0.5">Proyek: Pembangunan Rumah Tinggal</p>
                            </div>
                            <div class="flex items-center justify-between text-[11px] text-slate-500 font-semibold border-t border-slate-100 pt-3">
                                <span>Format: PNG (3.2 MB)</span>
                                <a href="#" class="text-blue-600 hover:underline font-bold">Unduh Berkas 📥</a>
                            </div>
                        </div>
                    </div>

                    <!-- Sample Card Desain 2 -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200/80 group hover:shadow-md transition">
                        <div class="relative h-48 bg-slate-200 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=600&q=80" alt="Denah 2D" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <span class="absolute top-3 left-3 bg-slate-900 text-white text-[10px] font-black uppercase px-2.5 py-1 rounded-lg">Denah 2D</span>
                        </div>
                        <div class="p-5 space-y-3">
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition">Layout Tata Ruang Lantai 1 & 2</h3>
                                <p class="text-[11px] font-medium text-slate-400 mt-0.5">Proyek: Ruko Komersial 2 Lantai</p>
                            </div>
                            <div class="flex items-center justify-between text-[11px] text-slate-500 font-semibold border-t border-slate-100 pt-3">
                                <span>Format: PDF / DWG</span>
                                <a href="#" class="text-blue-600 hover:underline font-bold">Unduh Berkas 📥</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card Tambah Desain Baru -->
                    <div onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 hover:border-blue-400 flex flex-col items-center justify-center p-8 text-center cursor-pointer min-h-[280px] transition group">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-md text-xl group-hover:scale-110 transition">✏️</div>
                        <h4 class="text-xs font-bold text-slate-700 mt-3">Upload Berkas Desain Baru</h4>
                        <p class="text-[10px] text-slate-400 mt-1">Mendukung format PDF, DWG, PNG, JPG</p>
                    </div>

                </div>

            </div>
        </main>

    </div>

    <!-- Modal Upload Desain -->
    <div id="uploadModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl">
            <div class="flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-base">Upload File Desain</h3>
                <button onclick="document.getElementById('uploadModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Judul Desain</label>
                    <input type="text" placeholder="Contoh: Layout Instalasi Listrik" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-semibold focus:outline-none focus:border-blue-600" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kategori</label>
                    <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs font-semibold focus:outline-none focus:border-blue-600">
                        <option>Denah 2D (CAD)</option>
                        <option>Render 3D</option>
                        <option>Detail M.E.P</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pilih Berkas File</label>
                    <input type="file" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/20 hover:bg-blue-700">Simpan Desain</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>