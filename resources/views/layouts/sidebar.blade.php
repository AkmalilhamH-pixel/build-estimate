<div class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between shadow-xl shrink-0 min-h-screen">
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
            
            <!-- 1. Dashboard Proyek (Semua Role) -->
            <a href="{{ route('estimates.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('estimates.index', 'estimates.show', 'estimates.create', 'estimates.edit') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/10' : 'hover:bg-slate-800 hover:text-white font-semibold' }} rounded-xl text-sm transition">
                <span class="text-base">📊</span> Dashboard Proyek
            </a>

            <!-- 2. Analisa Lahan -->
            <a href="{{ route('estimates.analisis-lahan') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('estimates.analisis-lahan') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/10' : 'hover:bg-slate-800 hover:text-white font-semibold' }} rounded-xl text-sm transition">
                <span class="text-base">📍</span> Analisa Lahan
            </a>

            <!-- 3. Desain & Blueprint -->
            <a href="{{ route('designs.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('designs.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/10' : 'hover:bg-slate-800 hover:text-white font-semibold' }} rounded-xl text-sm transition">
                <span class="text-base">📐</span> Desain & Blueprint
            </a>

            <!-- 4. Konsultasi Proyek (BARU) -->
            <a href="{{ route('consultations.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('consultations.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/10' : 'hover:bg-slate-800 hover:text-white font-semibold' }} rounded-xl text-sm transition">
                <span class="text-base">🎧</span> Konsultasi Proyek
            </a>

            <!-- 5. Data Klien & Mitra (KHUSUS ADMIN) -->
            @if(auth()->user()->isAdmin())
                <a href="{{ route('clients.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('clients.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/10' : 'hover:bg-slate-800 hover:text-white font-semibold' }} rounded-xl text-sm transition">
                    <span class="text-base">👥</span> Data Klien / Pemilik
                </a>

                <a href="{{ route('contractors.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('contractors.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/10' : 'hover:bg-slate-800 hover:text-white font-semibold' }} rounded-xl text-sm transition">
                    <span class="text-base">🏗️</span> Mitra Kontraktor
                </a>
            @endif

            <!-- 6. Rekapitulasi Biaya (Semua Role) -->
            <a href="{{ route('recap.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('recap.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/10' : 'hover:bg-slate-800 hover:text-white font-semibold' }} rounded-xl text-sm transition">
                <span class="text-base">💰</span> Rekapitulasi Biaya
            </a>

            <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 pt-4 mb-2">Sistem</p>

            <!-- 7. Pengaturan Profil (Semua Role) -->
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('profile.*') ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/10' : 'hover:bg-slate-800 hover:text-white font-semibold' }} rounded-xl text-sm transition">
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
                <div class="flex items-center gap-1.5 mb-0.5">
                    <p class="text-xs font-bold text-white truncate leading-none">{{ auth()->user()->name }}</p>
                </div>
                <span class="text-[9px] font-black uppercase px-1.5 py-0.5 rounded bg-blue-950 text-blue-400 border border-blue-800/50">
                    Role: {{ auth()->user()->role }}
                </span>
            </div>
        </div>

        <!-- Form Logout dengan JavaScript Trigger -->
        <form action="{{ route('logout') }}" method="POST" id="logoutForm">
            @csrf
            <button type="button" onclick="confirmLogout()" class="w-full flex items-center justify-center gap-2 bg-red-950/40 text-red-400 border border-red-900/40 px-3 py-2 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-red-900/30 hover:text-red-300 transition cursor-pointer">
                🚪 Keluar (Logout)
            </button>
        </form>
    </div>
</div>

<!-- Skrip JavaScript Logout -->
<script>
    function confirmLogout() {
        if (confirm('Apakah Anda yakin ingin keluar dari aplikasi?')) {
            document.getElementById('logoutForm').submit();
        }
    }
</script>