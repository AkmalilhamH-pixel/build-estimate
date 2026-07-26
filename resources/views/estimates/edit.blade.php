<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Estimasi</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-md">
        
        <!-- LOGO ATAS -->
        <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-5">
            <div class="bg-blue-600 text-white p-2 rounded-lg shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12a2.25 2.25 0 012.25 2.25V21M3 3V2.25A.75.75 0 013.75 1.5h1.5a.75.75 0 01.75.75V3m0 0h5.25" />
                </svg>
            </div>
            <h1 class="text-xl font-black text-gray-900">Build<span class="text-blue-600">Estimate</span></h1>
        </div>

        <h2 class="text-lg font-bold mb-4 text-gray-700">Edit Proyek</h2>
        <form action="{{ route('estimates.update', $estimate->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold text-sm mb-2">Nama Proyek</label>
                <input type="text" name="nama_proyek" value="{{ $estimate->nama_proyek }}" class="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Nama Klien</label>
                    <input type="text" name="nama_klien" value="{{ $estimate->nama_klien }}" class="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Luas Bangunan (m²)</label>
                    <input type="number" name="luas_bangunan" value="{{ $estimate->luas_bangunan }}" class="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold text-sm mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="2" class="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500">{{ $estimate->deskripsi }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold text-sm mb-2">Status Proyek</label>
                <select name="status_proyek" class="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500" required>
                    <option value="Draft" {{ $estimate->status_proyek == 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Negosiasi" {{ $estimate->status_proyek == 'Negosiasi' ? 'selected' : '' }}>Negosiasi</option>
                    <option value="Disetujui / Berjalan" {{ $estimate->status_proyek == 'Disetujui / Berjalan' ? 'selected' : '' }}>Disetujui / Berjalan</option>
                    <option value="Ditolak" {{ $estimate->status_proyek == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold text-sm mb-2">Estimasi Biaya (Rp)</label>
                <input type="number" name="estimasi_biaya" value="{{ $estimate->estimasi_biaya }}" class="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition shadow-sm">Update</button>
                <a href="{{ route('estimates.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>