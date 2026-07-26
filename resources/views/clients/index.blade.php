<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Klien - Build Estimate</title>
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

                <!-- NOTIFIKASI SUKSES -->
                @if(session('success'))
                    <div class="bg-green-50 text-green-700 p-3 rounded-xl border border-green-200 font-medium text-sm shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- JUDUL HALAMAN -->
                <div>
                    <h2 class="text-xl font-black text-gray-900 tracking-tight">Manajemen Data Klien</h2>
                    <p class="text-xs text-gray-400 font-semibold mt-0.5">Kelola database seluruh pemilik proyek</p>
                </div>

                <!-- KONTEN UTAMA: GRID FORM & TABEL -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    
                    <!-- FORM TAMBAH KLIEN -->
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200/80">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-wider mb-4">Tambah Klien Baru</h3>
                        <form action="{{ route('clients.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama Klien / Instansi</label>
                                <input type="text" name="nama_klien" placeholder="Contoh: Pak Aris / PT. Maju Jaya" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500 font-medium" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">No. Telepon / WhatsApp</label>
                                <input type="text" name="no_telp" placeholder="Contoh: 081234567890" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500 font-medium">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Alamat Email</label>
                                <input type="email" name="email" placeholder="Contoh: klien@email.com" class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500 font-medium">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Alamat Rumah / Kantor</label>
                                <textarea name="alamat" rows="3" placeholder="Tulis alamat korespondensi lengkap..." class="w-full text-sm border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-blue-500 font-medium"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-xl font-bold text-sm hover:bg-blue-700 transition shadow-md shadow-blue-600/10 cursor-pointer">
                                Simpan Data Klien
                            </button>
                        </form>
                    </div>

                    <!-- TABEL DATABASE KLIEN -->
                    <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="p-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-xs font-black text-gray-500 uppercase tracking-wider">Database Mitra Terdaftar</h3>
                        </div>
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 uppercase text-[10px] font-bold tracking-wider border-b border-gray-200">
                                    <th class="p-4 text-center w-12">No</th>
                                    <th class="p-4">Nama Klien</th>
                                    <th class="p-4">Informasi Kontak</th>
                                    <th class="p-4">Alamat</th>
                                    <th class="p-4 text-center w-24">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                                @forelse($clients as $index => $client)
                                    <tr class="hover:bg-gray-50/40 transition">
                                        <td class="p-4 text-center text-gray-400 font-semibold">{{ $index + 1 }}</td>
                                        <td class="p-4 font-bold text-gray-900">{{ $client->nama_klien }}</td>
                                        <td class="p-4 text-xs space-y-0.5">
                                            <p class="font-bold text-gray-700">📞 {{ $client->no_telp ?? '-' }}</p>
                                            <p class="text-gray-400">✉️ {{ $client->email ?? '-' }}</p>
                                        </td>
                                        <td class="p-4 text-xs text-gray-500 max-w-xs truncate">{{ $client->alamat ?? '-' }}</td>
                                        <td class="p-4 text-center">
                                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Hapus permanen data klien ini?')">
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
                                            Belum ada data klien terdaftar. Gunakan formulir di sebelah kiri untuk menambah.
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