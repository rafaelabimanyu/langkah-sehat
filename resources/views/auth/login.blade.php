<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - HealthyWay</title>
    
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
<body class="bg-[#edf3f6] min-h-screen text-[#1e293b] base-font flex items-center justify-center p-4 md:p-6 antialiased">

    <!-- Auth Card Container -->
    <div class="w-full max-w-md bg-white/80 backdrop-blur-lg border border-slate-200 shadow-xl rounded-3xl p-8 relative overflow-hidden">
        
        <!-- Decorative Glow Effects -->
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-[#7da8b6]/20 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-[#5c8d9d]/10 rounded-full blur-2xl"></div>

        <!-- Logo/Branding -->
        <div class="flex flex-col items-center mb-8 relative z-10">
            <div class="w-14 h-14 rounded-full bg-[#5c8d9d]/10 flex items-center justify-center border border-[#5c8d9d]/20 mb-3 animate-pulse">
                <i class="fa-solid fa-heart-pulse text-[#4a7a8a] text-2xl"></i>
            </div>
            <h2 class="font-extrabold text-2xl tracking-wider text-[#1a365d]">HealthyWay</h2>
            <p class="text-xs text-slate-500 mt-1 body-font">Log Masuk Aplikasi Self Tracking Perjalanan</p>
        </div>

        <!-- Toast Notifications / Success Alerts -->
        @if(session('success'))
            <div class="mb-5 bg-emerald-50 border border-emerald-200 px-4 py-3 rounded-2xl flex items-center space-x-3 text-emerald-700 text-sm body-font shadow-sm">
                <i class="fa-solid fa-circle-check text-base shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-5 bg-rose-50 border border-rose-200 px-4 py-3 rounded-2xl flex items-center space-x-3 text-rose-700 text-sm body-font shadow-sm">
                <i class="fa-solid fa-circle-exmark text-base shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form action="/login" method="POST" class="space-y-5 relative z-10 body-font">
            @csrf
            
            <!-- Email Field -->
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-500 tracking-wider uppercase mb-2">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-white border border-slate-200 rounded-2xl pl-10 pr-4 py-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all shadow-sm"
                        placeholder="nama@email.com">
                </div>
                @error('email')
                    <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-xs font-semibold text-slate-500 tracking-wider uppercase">Kata Sandi</label>
                </div>
                <div class="relative" x-data="{ show: false }">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input :type="show ? 'text' : 'password'" name="password" id="password" required
                        class="w-full bg-white border border-slate-200 rounded-2xl pl-10 pr-10 py-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all shadow-sm"
                        placeholder="••••••••">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-[#4a7a8a] transition-colors">
                        <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me Checkbox -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded bg-white border border-slate-300 text-[#4a7a8a] focus:ring-[#7da8b6] focus:ring-offset-0">
                <label for="remember" class="ml-2 text-xs text-slate-600 select-none">Ingat saya di perangkat ini</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 bg-[#4a7a8a] hover:bg-[#3b6370] text-white font-bold rounded-full tracking-wide shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer">
                Masuk Sekarang
            </button>
        </form>

        <!-- Redirection link -->
        <div class="mt-8 text-center text-xs text-slate-500 relative z-10 body-font">
            Belum memiliki akun? 
            <a href="/register" class="text-[#4a7a8a] hover:text-[#1a365d] font-bold transition-colors ml-1">Daftar Akun Baru</a>
        </div>
    </div>
</body>
</html>
