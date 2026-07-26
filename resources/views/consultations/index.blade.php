<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi Proyek - Build Estimate</title>
    <!-- Tailwind CSS v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
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
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Konsultasi & Diskusi Proyek</h1>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Ruang komunikasi langsung antara Klien, Kontraktor, dan Tim Admin</p>
                    </div>
                </div>

                @if($estimates->isEmpty())
                    <div class="bg-white p-12 rounded-3xl text-center border border-slate-200/80">
                        <p class="text-slate-500 font-semibold text-sm">Belum ada proyek aktif untuk diajukan konsultasi.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        <!-- SISI KIRI: Daftar Pilihan Proyek -->
                        <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-200/80 space-y-4 h-fit">
                            <h2 class="text-xs font-black text-slate-400 uppercase tracking-wider">Pilih Proyek</h2>
                            <div class="space-y-2">
                                @foreach($estimates as $est)
                                    <a href="{{ route('consultations.index', ['estimate_id' => $est->id]) }}" 
                                       class="block p-4 rounded-2xl border transition {{ $activeEstimate && $activeEstimate->id == $est->id ? 'bg-blue-50/80 border-blue-500 text-blue-900' : 'bg-slate-50/50 border-slate-100 hover:bg-slate-100/80 text-slate-700' }}">
                                        <p class="font-bold text-sm truncate">{{ $est->nama_proyek }}</p>
                                        <div class="flex justify-between items-center mt-2 text-[11px] font-semibold text-slate-400">
                                            <span>Klien: {{ $est->nama_klien ?? 'Umum' }}</span>
                                            <span class="px-2 py-0.5 rounded bg-slate-200 text-slate-700 uppercase font-extrabold text-[9px]">{{ $est->status_proyek }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- SISI KANAN: Ruang Obrolan (Chat Room) -->
                        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-200/80 flex flex-col h-[600px]">
                            
                            <!-- Header Chat Proyek Active -->
                            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50 rounded-t-3xl">
                                <div>
                                    <h3 class="font-bold text-slate-800 text-sm">{{ $activeEstimate->nama_proyek }}</h3>
                                    <p class="text-[11px] font-medium text-slate-400">Diskusi terbuka untuk semua stakeholder proyek</p>
                                </div>
                                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">Grup Diskusi</span>
                            </div>

                            <!-- Area Ringkasan Obrolan -->
                            <div class="flex-1 p-6 overflow-y-auto space-y-4" id="chatContainer">
                                @forelse($messages as $msg)
                                    @php $isMe = $msg->user_id === auth()->id(); @endphp
                                    <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                                        <div class="flex items-center gap-1.5 mb-1">
                                            <span class="text-[10px] font-bold text-slate-500">{{ $msg->user->name }}</span>
                                            <span class="text-[9px] font-black uppercase px-1.5 py-0.2 rounded {{ $msg->user->isAdmin() ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600' }}">
                                                {{ $msg->user->role }}
                                            </span>
                                            <span class="text-[9px] text-slate-300">{{ $msg->created_at->format('H:i') }}</span>
                                        </div>
                                        <div class="max-w-md px-4 py-3 rounded-2xl text-xs font-medium leading-relaxed shadow-sm {{ $isMe ? 'bg-blue-600 text-white rounded-tr-none' : 'bg-slate-100 text-slate-800 rounded-tl-none' }}">
                                            {{ $msg->message }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="h-full flex flex-col items-center justify-center text-center text-slate-400 space-y-2">
                                        <span class="text-3xl">💬</span>
                                        <p class="text-xs font-semibold">Belum ada obrolan. Mulai konsultasi mengenai proyek ini.</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Form Kirim Pesan -->
                            <form action="{{ route('consultations.store') }}" method="POST" class="p-4 border-t border-slate-100 flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="estimate_id" value="{{ $activeEstimate->id }}">
                                <input type="text" name="message" placeholder="Tulis pesan konsultasi..." class="flex-1 bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs font-semibold text-slate-800 focus:outline-none focus:border-blue-600 transition" required autocomplete="off">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-3 rounded-2xl text-xs uppercase tracking-wider transition cursor-pointer shadow-md shadow-blue-600/20">
                                    Kirim 🚀
                                </button>
                            </form>

                        </div>

                    </div>
                @endif

            </div>
        </main>

    </div>

    <script>
        // Otomatis scroll ke bagian bawah pesan terbaru
        const chatContainer = document.getElementById('chatContainer');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    </script>
</body>
</html>