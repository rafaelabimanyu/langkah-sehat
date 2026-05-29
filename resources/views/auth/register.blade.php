<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Langkah Sehat</title>
    
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
    <div class="w-full max-w-md bg-white/10 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl p-8 relative overflow-hidden my-6">
        
        <!-- Decorative Glow Effects -->
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-cyan-500/20 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-emerald-500/20 rounded-full blur-2xl"></div>

        <!-- Logo/Branding -->
        <div class="flex flex-col items-center mb-6 relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-cyan-400 to-emerald-400 flex items-center justify-center shadow-lg shadow-cyan-500/30 mb-3 animate-pulse">
                <i class="fa-solid fa-heart-pulse text-slate-950 text-2xl"></i>
            </div>
            <h2 class="font-extrabold text-2xl tracking-wider bg-gradient-to-r from-cyan-300 to-emerald-300 bg-clip-text text-transparent">Langkah Sehat</h2>
            <p class="text-xs text-white/50 mt-1 body-font">Pendaftaran Akun Baru Sistem Mandiri</p>
        </div>

        <!-- Form -->
        <form action="/register" method="POST" class="space-y-4 relative z-10 body-font">
            @csrf
            
            <!-- Name Field -->
            <div>
                <label for="name" class="block text-xs font-semibold text-white/70 tracking-wider uppercase mb-1">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/40">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                        class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/10 transition-all"
                        placeholder="Nama Lengkap Anda">
                </div>
                @error('name')
                    <p class="text-xs text-rose-300 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-xs font-semibold text-white/70 tracking-wider uppercase mb-1">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/40">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/10 transition-all"
                        placeholder="nama@email.com">
                </div>
                @error('email')
                    <p class="text-xs text-rose-300 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Selection Field (Easy Testing) -->
            <div>
                <label for="role" class="block text-xs font-semibold text-white/70 tracking-wider uppercase mb-1">Pilih Peran (Role)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/40">
                        <i class="fa-solid fa-user-shield"></i>
                    </span>
                    <select name="role" id="role"
                        class="w-full bg-slate-900 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-slate-900 transition-all">
                        <option value="masyarakat" {{ old('role') === 'masyarakat' ? 'selected' : '' }}>Masyarakat (Catatan Perjalanan)</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Supervisory/Global)</option>
                    </select>
                </div>
                @error('role')
                    <p class="text-xs text-rose-300 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-xs font-semibold text-white/70 tracking-wider uppercase mb-1">Kata Sandi</label>
                <div class="relative" x-data="{ show: false }">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/40">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input :type="show ? 'text' : 'password'" name="password" id="password" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-10 py-2.5 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/10 transition-all"
                        placeholder="Min. 8 karakter">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-white/40 hover:text-white transition-colors">
                        <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs text-rose-300 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation Field -->
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-white/70 tracking-wider uppercase mb-1">Konfirmasi Kata Sandi</label>
                <div class="relative" x-data="{ show: false }">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/40">
                        <i class="fa-solid fa-lock-open"></i>
                    </span>
                    <input :type="show ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-10 py-2.5 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/10 transition-all"
                        placeholder="Ketik ulang kata sandi">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-white/40 hover:text-white transition-colors">
                        <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 mt-2 bg-gradient-to-r from-cyan-500 to-emerald-500 hover:from-cyan-600 hover:to-emerald-600 border-none rounded-xl text-slate-950 font-bold tracking-wide shadow-lg shadow-cyan-500/25 hover:shadow-cyan-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 cursor-pointer">
                Daftarkan Akun
            </button>
        </form>

        <!-- Redirection link -->
        <div class="mt-6 text-center text-xs text-white/50 relative z-10 body-font">
            Sudah memiliki akun? 
            <a href="/login" class="text-cyan-300 hover:text-cyan-100 font-bold transition-colors ml-1">Masuk disini</a>
        </div>
    </div>
</body>
</html>
