<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisa Lahan - Build Estimate</title>
    <!-- Tailwind CSS v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Leaflet CSS untuk Peta Interaktif -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        #map { height: 280px; width: 100%; border-radius: 1.5rem; z-index: 10; }
    </style>
</head>
<body class="bg-slate-100/70 font-sans antialiased transition-opacity duration-300 opacity-100" id="pageBody">

    <!-- ─── WRAPPER UTAMA ─── -->
    <div class="flex min-h-screen">

        <!-- ─── SIDEBAR ─── -->
        @include('layouts.sidebar')

        <!-- ─── MAIN CONTENT ─── -->
        <main class="flex-1 p-6 md:p-8 overflow-y-auto">
            <div class="max-w-6xl mx-auto space-y-6">

                <!-- Header Halaman -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Analisa Lahan & Pembangunan</h1>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Evaluasi titik koordinat, dimensi tanah, dan rekomendasi struktur RAB</p>
                    </div>
                    <a href="{{ route('estimates.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 px-4 py-2 rounded-xl transition">
                        ← Kembali ke Dashboard Proyek
                    </a>
                </div>

                <!-- Grid Utama (Form & Hasil Analisa) -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- SISI KIRI & TENGAH: Peta & Form Input Parameter Lahan -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Peta Interaktif -->
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 space-y-4">
                            <h2 class="text-sm font-black text-slate-700 uppercase tracking-wider">Titik Lokasi Lahan (Peta)</h2>
                            <div id="map" class="shadow-inner border border-slate-200"></div>
                            <p class="text-[11px] text-slate-400 font-medium italic">*Klik pada peta untuk menyesuaikan koordinat titik lokasi proyek konstruksi.</p>
                        </div>

                        <!-- Form Parameter Analisa -->
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 space-y-5">
                            <h2 class="text-sm font-black text-slate-700 uppercase tracking-wider">Parameter Dimensi & Jenis Lahan</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Lokasi Input -->
                                <div class="md:col-span-2 space-y-1.5">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Lokasi / Alamat Lahan</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">🔍</span>
                                        <input type="text" id="inputLokasi" value="Magelang, Jawa Tengah" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-4 py-3 font-semibold text-slate-800 focus:outline-none focus:border-blue-600 transition">
                                    </div>
                                </div>

                                <!-- Jenis Lahan -->
                                <div class="md:col-span-2 space-y-1.5">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis Lahan</label>
                                    <select id="jenisLahan" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 font-semibold text-slate-800 focus:outline-none focus:border-blue-600 transition cursor-pointer">
                                        <option value="perumahan">Tanah Matang / Perumahan (KDB Max 60%)</option>
                                        <option value="komersial">Kawasan Komersial / Ruko (KDB Max 80%)</option>
                                        <option value="miring">Lahan Kontur Miring / Berbukit</option>
                                        <option value="pertanian">Konversi Lahan Pertanian / Kosong</option>
                                    </select>
                                </div>

                                <!-- Lebar Tanah (m) -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Lebar Tanah (Meter)</label>
                                    <input type="number" id="lebarTanah" value="10" min="1" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 font-semibold text-slate-800 focus:outline-none focus:border-blue-600 transition" placeholder="Contoh: 10">
                                </div>

                                <!-- Panjang Tanah (m) -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Panjang Tanah (Meter)</label>
                                    <input type="number" id="panjangTanah" value="20" min="1" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 font-semibold text-slate-800 focus:outline-none focus:border-blue-600 transition" placeholder="Contoh: 20">
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- SISI KANAN: Hasil Rekomendasi & Output Analisa (Mirip Figma) -->
                    <div class="space-y-6">

                        <!-- Kartu Rekomendasi Tipe Bangunan (Aksen Kuning) -->
                        <div class="bg-amber-400 p-6 rounded-3xl shadow-lg shadow-amber-400/20 text-slate-900 space-y-4 relative overflow-hidden">
                            <div class="absolute -right-6 -bottom-6 text-7xl opacity-20">🏢</div>
                            <div class="flex items-center gap-3">
                                <span class="text-2xl bg-white/60 p-2.5 rounded-2xl">🏛️</span>
                                <div>
                                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800">Rekomendasi</h3>
                                    <h2 class="text-lg font-black tracking-tight">Tipe Bangunan Optimal</h2>
                                </div>
                            </div>
                            
                            <div class="bg-white/90 backdrop-blur-md p-4 rounded-2xl space-y-2 text-xs font-bold">
                                <div class="flex justify-between border-b border-slate-100 pb-2">
                                    <span class="text-slate-500">Total Luas Tanah:</span>
                                    <span id="resLuasTotal" class="text-blue-600 font-black text-sm">200 m²</span>
                                </div>
                                <div class="flex justify-between border-b border-slate-100 pb-2">
                                    <span class="text-slate-500">Maks. Luas Lantai (KDB):</span>
                                    <span id="resKdb" class="text-slate-800 font-black">120 m² (60%)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Rekomendasi Struktur:</span>
                                    <span id="resStruktur" class="text-slate-800 font-black">Rumah Tinggal 2 Lantai</span>
                                </div>
                            </div>
                        </div>

                        <!-- Kartu Estimasi Pagu & Biaya Dasar -->
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 space-y-4">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Estimasi Anggaran Awal</h3>
                            
                            <div class="space-y-3">
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <p class="text-[11px] font-bold text-slate-400 uppercase">Perkiraan Biaya Konstruksi</p>
                                    <p id="resEstimasiBiaya" class="text-lg font-black text-blue-600 mt-1">Rp 450.000.000</p>
                                </div>
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <p class="text-[11px] font-bold text-slate-400 uppercase">Indeks Biaya per m²</p>
                                    <p class="text-sm font-extrabold text-slate-700 mt-1">Rp 3.750.000 / m²</p>
                                </div>
                            </div>

                            <button onclick="simpanKeProyek()" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-blue-600/20 transition cursor-pointer flex items-center justify-center gap-2">
                                <span>Simpan ke Data Proyek</span>
                            </button>
                        </div>

                    </div>

                </div>

            </div>
        </main>

    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // 1. Inisialisasi Peta Leaflet (Titik Default: Magelang)
        var map = L.map('map').setView([-7.4706, 110.2178], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker([-7.4706, 110.2178]).addTo(map)
            .bindPopup("<b>Lokasi Analisa Lahan</b><br>Build Estimate System.").openPopup();

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            marker.popup.setLatLng(e.latlng).setContent("Koordinat: " + e.latlng.lat.toFixed(4) + ", " + e.latlng.lng.toFixed(4)).openOn(map);
        });

        // 2. Kalkulator Otomatis Analisa Lahan (Lebar x Panjang)
        const inputLebar = document.getElementById('lebarTanah');
        const inputPanjang = document.getElementById('panjangTanah');
        const selectJenis = document.getElementById('jenisLahan');
        
        const resLuasTotal = document.getElementById('resLuasTotal');
        const resKdb = document.getElementById('resKdb');
        const resStruktur = document.getElementById('resStruktur');
        const resEstimasiBiaya = document.getElementById('resEstimasiBiaya');

        function hitungAnalisa() {
            let lebar = parseFloat(inputLebar.value) || 0;
            let panjang = parseFloat(inputPanjang.value) || 0;
            let luas = lebar * panjang;

            resLuasTotal.textContent = luas + " m²";

            let kdbPersen = 0.60;
            let jenis = selectJenis.value;
            if (jenis === 'komersial') kdbPersen = 0.80;
            if (jenis === 'miring') kdbPersen = 0.50;

            let luasKdb = Math.round(luas * kdbPersen);
            resKdb.textContent = luasKdb + " m² (" + (kdbPersen * 100) + "%)";

            let struktur = "Rumah Tinggal 1 Lantai";
            let biayaPerM2 = 3500000;
            if (luas > 150 || jenis === 'komersial') {
                struktur = "Gedung / Ruko 2 Lantai";
                biayaPerM2 = 4200000;
            }
            if (jenis === 'miring') {
                struktur = "Struktur Khusus / Panggung";
                biayaPerM2 = 4800000;
            }
            resStruktur.textContent = struktur;

            let totalBiaya = luasKdb * biayaPerM2;
            resEstimasiBiaya.textContent = "Rp " + totalBiaya.toLocaleString('id-ID');
        }

        inputLebar.addEventListener('input', hitungAnalisa);
        inputPanjang.addEventListener('input', hitungAnalisa);
        selectJenis.addEventListener('change', hitungAnalisa);

        function simpanKeProyek() {
            let lebar = parseFloat(inputLebar.value) || 0;
            let panjang = parseFloat(inputPanjang.value) || 0;
            let luasTotal = lebar * panjang;

            let jenis = selectJenis.value;
            let kdbPersen = 0.60;
            if (jenis === 'komersial') kdbPersen = 0.80;
            if (jenis === 'miring') kdbPersen = 0.50;

            let luasKdb = Math.round(luasTotal * kdbPersen);

            let biayaPerM2 = 3500000;
            if (luasTotal > 150 || jenis === 'komersial') biayaPerM2 = 4200000;
            if (jenis === 'miring') biayaPerM2 = 4800000;
            let totalBiaya = luasKdb * biayaPerM2;

            let lokasi = document.getElementById('inputLokasi').value;

            // Mengirim data hasil analisa melalui parameter URL ke form tambah proyek
            let url = "{{ route('estimates.create') }}" + "?luas=" + luasKdb + "&anggaran=" + totalBiaya + "&lokasi=" + encodeURIComponent(lokasi);
            window.location.href = url;
        }
    </script>

</body>
</html>