<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Build Estimate</title>
    <!-- Tailwind CSS v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-white min-h-screen transition-opacity duration-300 opacity-100 overflow-hidden" id="pageBody">

    <!-- Container Utama (Split Screen) -->
    <div class="flex min-h-screen w-full">

        <!-- ─── SISI KIRI: TEKS & BRANDING (Persis seperti gambar) ─── -->
        <!-- Sisi ini disembunyikan di layar kecil (mobile), muncul di layar besar (lg) -->
        <div class="hidden lg:flex lg:w-1/2 flex-col justify-center px-16 xl:px-24 bg-white">
            
            <!-- Aksen Garis Biru -->
            <div class="w-12 h-1.5 bg-blue-600 mb-10 rounded-full"></div>

            <!-- Teks Utama Build Estimate -->
            <h1 class="text-6xl xl:text-7xl font-black text-blue-600 tracking-tight leading-tight mb-2">
                Build <br> <span class="text-gray-900">Estimate</span>
            </h1>
            <h2 class="text-4xl xl:text-5xl font-extrabold text-gray-900 tracking-tight mb-10">
                RAB System
            </h2>

            <!-- Teks Bawah Slogan -->
            <p class="text-lg xl:text-xl text-gray-800 font-medium mt-16">
                that Mix <span class="text-blue-600 font-bold">Accuracy</span> with <span class="text-blue-600 font-bold">Convenience</span>
            </p>
        </div>

        <!-- ─── SISI KANAN: FORM LOGIN GLASSMORPHISM ─── -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 relative bg-slate-950">
            
            <!-- Efek Latar Belakang (Gradient Blobs Blur) -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-[-10%] left-[0%] w-96 h-96 bg-white/20 rounded-full mix-blend-overlay filter blur-[100px] opacity-50"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-blue-600/30 rounded-full mix-blend-screen filter blur-[120px] opacity-60"></div>
            </div>

            <!-- Kartu Login Transparan -->
            <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-2xl p-10 rounded-[2rem] border border-white/10 shadow-[0_8px_32px_0_rgba(0,0,0,0.3)]">
                
                <!-- Header Kartu -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2 tracking-wide">Hello!</h2>
                    <p class="text-sm text-gray-300 font-medium">We are really happy to see you again!</p>
                </div>

                <!-- Notifikasi Error -->
                @if($errors->any())
                    <div class="bg-red-500/20 border border-red-500/50 text-red-200 p-3 rounded-2xl text-xs font-semibold mb-6 flex items-center gap-2">
                        <span class="text-sm">⚠️</span> {{ $errors->first() }}
                    </div>
                @endif

                <!-- Notifikasi Sukses -->
                @if(session('success'))
                    <div class="bg-emerald-500/20 border border-emerald-500/50 text-emerald-200 p-3 rounded-2xl text-xs font-semibold mb-6 flex items-center gap-2">
                        <span class="text-sm">✅</span> {{ session('success') }}
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('login') }}" method="POST" id="loginForm" class="space-y-5">
                    @csrf
                    
                    <!-- Input Email (Putih Bersih seperti referensi) -->
                    <div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" class="w-full bg-white/95 text-gray-900 placeholder-gray-400 px-5 py-4 rounded-xl text-sm font-semibold focus:outline-none focus:ring-4 focus:ring-blue-500/30 transition shadow-inner" required autofocus>
                    </div>

                    <!-- Input Password dengan Toggle Mata -->
                    <div class="relative">
                        <input type="password" name="password" id="passwordInput" placeholder="Password" class="w-full bg-white/95 text-gray-900 placeholder-gray-400 px-5 py-4 pr-12 rounded-xl text-sm font-semibold focus:outline-none focus:ring-4 focus:ring-blue-500/30 transition shadow-inner" required>
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition cursor-pointer">
                            <!-- Ikon Mata Tertutup (SVG) -->
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Tombol Masuk Sistem -->
                    <button type="submit" id="submitBtn" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold text-sm hover:bg-blue-700 transition-colors duration-300 shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2 mt-2 cursor-pointer">
                        <span id="btnText">Sign in</span>
                        <span id="loadingSpinner" class="hidden animate-spin w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span>
                    </button>
                    
                    <!-- Remember Me -->
                    <div class="flex items-center justify-center pt-2">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-white/20 bg-white/10 text-blue-500 focus:ring-0 checked:bg-blue-500 transition cursor-pointer">
                            <span class="text-[11px] text-gray-300 font-semibold uppercase tracking-wider group-hover:text-white transition">Ingat saya di perangkat ini</span>
                        </label>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- ─── SCRIPT JAVASCRIPT ANIMASI LOKAL ─── -->
    <script>
        // 1. Fitur Toggle Password (Lihat/Sembunyikan)
        const togglePasswordBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePasswordBtn.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            
            // Ganti bentuk ikon SVG dari tertutup ke terbuka
            if (isPassword) {
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
            } else {
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>`;
            }
        });

        // 2. Efek Transisi Memudar & Spinner Saat Submit
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const pageBody = document.getElementById('pageBody');

        loginForm.addEventListener('submit', function (e) {
            btnText.textContent = 'Signing in...';
            loadingSpinner.classList.remove('hidden');
            submitBtn.setAttribute('disabled', 'true');
            submitBtn.classList.add('opacity-80', 'cursor-wait');

            // Fade out sebelum redirect dashboard
            setTimeout(() => {
                pageBody.classList.add('opacity-0');
            }, 100);
        });
    </script>

</body>
</html>