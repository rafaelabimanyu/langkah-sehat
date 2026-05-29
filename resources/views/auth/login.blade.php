<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Langkah Sehat</title>
    
    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js for interactions -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .base-font {
            font-family: 'Outfit', sans-serif;
        }
        .body-font {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-tr from-indigo-900 via-slate-950 to-blue-900 min-h-screen text-white base-font flex items-center justify-center p-4 md:p-6 antialiased">

    <!-- Auth Card Container -->
    <div class="w-full max-w-md bg-white/10 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl p-8 relative overflow-hidden">
        
        <!-- Decorative Glow Effects -->
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-cyan-500/20 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-emerald-500/20 rounded-full blur-2xl"></div>

        <!-- Logo/Branding -->
        <div class="flex flex-col items-center mb-8 relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-cyan-400 to-emerald-400 flex items-center justify-center shadow-lg shadow-cyan-500/30 mb-3 animate-pulse">
                <i class="fa-solid fa-heart-pulse text-slate-950 text-2xl"></i>
            </div>
            <h2 class="font-extrabold text-2xl tracking-wider bg-gradient-to-r from-cyan-300 to-emerald-300 bg-clip-text text-transparent">Langkah Sehat</h2>
            <p class="text-xs text-white/50 mt-1 body-font">Log Masuk Aplikasi Self Tracking Perjalanan</p>
        </div>

        <!-- Toast Notifications / Success Alerts -->
        @if(session('success'))
            <div class="mb-5 bg-emerald-500/20 border border-emerald-500/30 backdrop-blur-lg px-4 py-3 rounded-xl flex items-center space-x-3 text-emerald-300 text-sm body-font">
                <i class="fa-solid fa-circle-check text-base shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-5 bg-rose-500/20 border border-rose-500/30 backdrop-blur-lg px-4 py-3 rounded-xl flex items-center space-x-3 text-rose-300 text-sm body-font">
                <i class="fa-solid fa-circle-exmark text-base shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form action="/login" method="POST" class="space-y-5 relative z-10 body-font">
            @csrf
            
            <!-- Email Field -->
            <div>
                <label for="email" class="block text-xs font-semibold text-white/70 tracking-wider uppercase mb-2">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/40">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/10 transition-all"
                        placeholder="nama@email.com">
                </div>
                @error('email')
                    <p class="text-xs text-rose-300 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-xs font-semibold text-white/70 tracking-wider uppercase">Kata Sandi</label>
                </div>
                <div class="relative" x-data="{ show: false }">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/40">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input :type="show ? 'text' : 'password'" name="password" id="password" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-10 py-3 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/10 transition-all"
                        placeholder="••••••••">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-white/40 hover:text-white transition-colors">
                        <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs text-rose-300 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me Checkbox -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded bg-white/5 border border-white/10 text-cyan-500 focus:ring-cyan-400/50 focus:ring-offset-0">
                <label for="remember" class="ml-2 text-xs text-white/60 select-none">Ingat saya di perangkat ini</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 bg-gradient-to-r from-cyan-500 to-emerald-500 hover:from-cyan-600 hover:to-emerald-600 border-none rounded-xl text-slate-950 font-bold tracking-wide shadow-lg shadow-cyan-500/25 hover:shadow-cyan-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 cursor-pointer">
                Masuk Sekarang
            </button>
        </form>

        <!-- Redirection link -->
        <div class="mt-8 text-center text-xs text-white/50 relative z-10 body-font">
            Belum memiliki akun? 
            <a href="/register" class="text-cyan-300 hover:text-cyan-100 font-bold transition-colors ml-1">Daftar Akun Baru</a>
        </div>
    </div>
</body>
</html>
