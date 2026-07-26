<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil - Build Estimate</title>
    <!-- Tailwind CSS v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- ─── WRAPPER UTAMA (FLEXBOX) ─── -->
    <div class="flex min-h-screen">

        <!-- ─── 1. SIDEBAR PANEL ─── -->
        <div class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between shadow-xl shrink-0">
            <div>
                <!-- Bagian Logo Aplikasi -->
                <div class="p-6 border-b border-slate-800">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center font-black text-white text-lg shadow-md shadow-blue-500/30">E</span>
                        <div>
                            <h1 class="text-lg font-black tracking-tight text-white leading-none">Build <span class="text-blue-500">Estimate</span></h1>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-0.5">RAB Management</p>
                        </div>
                    </div>
                </div>

                <!-- Menu Navigasi & Fitur -->
                <div class="px-4 py-6 space-y-1.5">
                    <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Main Menu</p>
                    
                    <!-- Menu 1: Dashboard Proyek -->
                    <a href="{{ route('estimates.index') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-slate-800 hover:text-white rounded-xl font-semibold text-sm transition">
                        <span class="text-base">📊</span> Dashboard Proyek
                    </a>

                    <!-- Menu 2: Data Klien -->
                    <a href="{{ route('clients.index') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-slate-800 hover:text-white rounded-xl font-semibold text-sm transition">
                        <span class="text-base">👥</span> Data Klien / Pemilik
                    </a>

                    <!-- Menu 3: Rekapitulasi Biaya -->
                    <a href="{{ route('recap.index') }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-slate-800 hover:text-white rounded-xl font-semibold text-sm transition">
                        <span class="text-base">💰</span> Rekapitulasi Biaya
                    </a>

                    <!-- Menu 4: Grafik Logistik & Material -->
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 hover:bg-slate-800 hover:text-white rounded-xl font-semibold text-sm transition">
                        <span class="text-base">📈</span> Grafik Tren Material
                    </a>

                    <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 pt-4 mb-2">Sistem</p>

                    <!-- Menu 5: Pengaturan Akun (Aktif di Halaman Ini) -->
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 bg-blue-600 text-white rounded-xl font-bold text-sm transition shadow-md shadow-blue-600/10">
                        <span class="text-base">⚙️</span> Pengaturan Profil
                    </a>
                </div>
            </div>

            <!-- Bagian Bawah Sidebar: Profil Pengguna & Logout -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/40 space-y-3">
                <div class="flex items-center gap-3 px-2">
                    <div class="w-9 h-9 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-black text-xs text-blue-400 uppercase">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-white truncate leading-none mb-0.5">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-500 font-medium truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <!-- Form Logout -->
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari aplikasi?')">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-950/40 text-red-400 border border-red-900/40 px-3 py-2 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-red-900/30 hover:text-red-300 transition cursor-pointer">
                        🚪 Keluar (Logout)
                    </button>
                </form>
            </div>
        </div>

        <!-- ─── 2. MAIN CONTENT AREA ─── -->
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-3xl mx-auto space-y-6">

                <!-- NOTIFIKASI SUKSES -->
                @if(session('success'))
                    <div class="bg-green-50 text-green-700 p-4 rounded-2xl border border-green-200 font-semibold text-sm shadow-sm flex items-center gap-2">
                        <span>✅</span> {{ session('success') }}
                    </div>
                @endif

                <!-- NOTIFIKASI ERROR VALIDASI -->
                @if ($errors->any())
                    <div class="bg-red-50 text-red-700 p-4 rounded-2xl border border-red-200 font-medium text-sm shadow-sm space-y-1">
                        <p class="font-bold">Terjadi kesalahan input:</p>
                        <ul class="list-disc list-inside text-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- JUDUL HALAMAN -->
                <div>
                    <h2 class="text-xl font-black text-gray-900 tracking-tight">Pengaturan Akun & Profil</h2>
                    <p class="text-xs text-gray-400 font-semibold mt-0.5">Kelola informasi pribadi dan kata sandi akses akun kontraktor Anda</p>
                </div>

                <!-- FORM EDIT PROFIL -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200/80">
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <!-- INFORMASI DASAR -->
                        <div class="border-b border-gray-100 pb-4 mb-4">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-wider mb-3">Informasi Identitas</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full text-sm border border-gray-300 p-3 rounded-xl focus:outline-none focus:border-blue-500 font-medium" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Alamat Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full text-sm border border-gray-300 p-3 rounded-xl focus:outline-none focus:border-blue-500 font-medium" required>
                                </div>
                            </div>
                        </div>

                        <!-- GANTI PASSWORD -->
                        <div>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-wider mb-1">Keamanan & Kata Sandi</h3>
                            <p class="text-[11px] text-gray-400 font-medium mb-3">* Kosongkan kolom password jika tidak ingin mengubah kata sandi saat ini.</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Password Baru</label>
                                    <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full text-sm border border-gray-300 p-3 rounded-xl focus:outline-none focus:border-blue-500 font-medium">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="w-full text-sm border border-gray-300 p-3 rounded-xl focus:outline-none focus:border-blue-500 font-medium">
                                </div>
                            </div>
                        </div>

                        <!-- TOMBOL SIMPAN -->
                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-blue-700 transition shadow-md shadow-blue-600/10 cursor-pointer">
                                💾 Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- ─── SELESAI MAIN CONTENT AREA ─── -->

    </div>

</body>
</html>