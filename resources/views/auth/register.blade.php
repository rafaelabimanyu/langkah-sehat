<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - HealthyWay</title>
    
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
<body class="bg-[#edf3f6] min-h-screen text-[#1e293b] base-font flex items-center justify-center p-4 md:p-6 antialiased"
      x-data="{ loaded: false }" 
      x-init="window.addEventListener('load', () => setTimeout(() => loaded = true, 400))">

    <!-- Global Pre-loader -->
    <div x-show="!loaded" 
         x-transition:leave="transition opacity duration-500" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         class="fixed inset-0 z-[9999] bg-[#edf3f6] flex flex-col items-center justify-center pointer-events-none">
        <div class="w-20 h-20 rounded-full bg-white/80 border border-slate-200 shadow-xl flex items-center justify-center mb-4 relative">
            <div class="absolute inset-0 rounded-full bg-[#5c8d9d]/20 animate-ping"></div>
            <i class="fa-solid fa-heart-pulse text-[#4a7a8a] text-4xl relative z-10 animate-pulse"></i>
        </div>
        <h2 class="text-xl font-bold text-[#1a365d] tracking-widest animate-pulse">HealthyWay</h2>
    </div>

    <!-- Double Card Container -->
    <div class="w-full max-w-4xl bg-white/80 backdrop-blur-lg border border-slate-200 shadow-2xl rounded-[2.5rem] relative overflow-hidden my-6 flex flex-col md:flex-row transition-all duration-700 ease-out transform"
         x-data="{ show: false, email: '{{ old('email') }}', password: '', password_confirmation: '', name: '{{ old('name') }}' }"
         x-init="setTimeout(() => show = true, 100)" 
         :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
        
        <!-- Left Side: Branding / Trust Card -->
        <div class="w-full md:w-5/12 bg-gradient-to-br from-[#1a365d] to-[#4a7a8a] p-10 flex flex-col justify-between text-white relative overflow-hidden">
            <div class="absolute -top-16 -left-16 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-[#7da8b6]/20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center border border-white/20 shadow-lg">
                        <i class="fa-solid fa-heart-pulse text-white text-xl"></i>
                    </div>
                    <span class="font-extrabold text-2xl tracking-wider text-white drop-shadow-md">HealthyWay</span>
                </div>
                
                <h2 class="text-3xl font-bold mb-4 leading-tight">Bergabung<br>Bersama Kami</h2>
                <p class="text-sm text-slate-200 body-font leading-relaxed">Sistem pencatatan riwayat perjalanan mandiri yang terintegrasi, aman, dan dirancang khusus untuk memonitor kesehatan Anda sehari-hari.</p>
            </div>
            
            <div class="relative z-10 mt-10 space-y-4">
                <div class="flex items-center space-x-3 text-sm text-slate-200 bg-white/5 rounded-2xl p-3 border border-white/10 backdrop-blur-sm">
                    <i class="fa-solid fa-shield-halved text-[#7da8b6]"></i>
                    <span>Enkripsi Data Standar Medis</span>
                </div>
                <div class="flex items-center space-x-3 text-sm text-slate-200 bg-white/5 rounded-2xl p-3 border border-white/10 backdrop-blur-sm">
                    <i class="fa-solid fa-temperature-three-quarters text-[#7da8b6]"></i>
                    <span>Analisis Suhu Tubuh Real-time</span>
                </div>
                <div class="flex items-center space-x-3 text-sm text-slate-200 bg-white/5 rounded-2xl p-3 border border-white/10 backdrop-blur-sm">
                    <i class="fa-solid fa-file-medical text-[#7da8b6]"></i>
                    <span>Cetak Riwayat PDF Sekali Klik</span>
                </div>
            </div>
        </div>

        <!-- Right Side: Registration Form -->
        <div class="w-full md:w-7/12 p-8 md:p-12 relative">
            <h3 class="text-2xl font-bold text-[#1a365d] mb-1">Daftar Akun Baru</h3>
            <p class="text-sm text-slate-500 mb-8 body-font">Lengkapi data diri Anda untuk memulai log perjalanan.</p>

            <form action="/register" method="POST" class="space-y-5 body-font">
                @csrf
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-[11px] font-bold text-slate-500 tracking-wider uppercase mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400" :class="name.length > 2 ? 'text-emerald-500' : 'text-slate-400'">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" name="name" id="name" x-model="name" required autofocus
                            class="w-full bg-slate-50 border rounded-2xl pl-11 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none transition-all shadow-sm"
                            :class="name.length > 2 ? 'border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:bg-white' : 'border-slate-200 focus:ring-2 focus:ring-[#7da8b6] focus:bg-white'"
                            placeholder="Nama Lengkap Anda">
                        <span x-show="name.length > 2" class="absolute inset-y-0 right-0 flex items-center pr-4 text-emerald-500">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </div>
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1.5 font-medium flex items-center"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-[11px] font-bold text-slate-500 tracking-wider uppercase mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4" :class="email.includes('@') && email.includes('.') ? 'text-emerald-500' : 'text-slate-400'">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email" name="email" id="email" x-model="email" required
                                class="w-full bg-slate-50 border rounded-2xl pl-11 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none transition-all shadow-sm"
                                :class="email.includes('@') && email.includes('.') ? 'border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:bg-white' : 'border-slate-200 focus:ring-2 focus:ring-[#7da8b6] focus:bg-white'"
                                placeholder="nama@email.com">
                        </div>
                        @error('email')
                            <p class="text-xs text-rose-500 mt-1.5 font-medium flex items-center"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role Field -->
                    <div>
                        <label for="role" class="block text-[11px] font-bold text-slate-500 tracking-wider uppercase mb-1.5">Pilih Peran</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#4a7a8a]">
                                <i class="fa-solid fa-user-shield"></i>
                            </span>
                            <select name="role" id="role"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-4 py-3 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:bg-white transition-all shadow-sm">
                                <option value="masyarakat" {{ old('role') === 'masyarakat' ? 'selected' : '' }}>Masyarakat Umum</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                        </div>
                        @error('role')
                            <p class="text-xs text-rose-500 mt-1.5 font-medium flex items-center"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-[11px] font-bold text-slate-500 tracking-wider uppercase mb-1.5">Kata Sandi</label>
                        <div class="relative" x-data="{ showPass: false }">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4" :class="password.length >= 8 ? 'text-emerald-500' : 'text-slate-400'">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input :type="showPass ? 'text' : 'password'" name="password" id="password" x-model="password" required
                                class="w-full bg-slate-50 border rounded-2xl pl-11 pr-10 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none transition-all shadow-sm"
                                :class="password.length >= 8 ? 'border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:bg-white' : 'border-slate-200 focus:ring-2 focus:ring-[#7da8b6] focus:bg-white'"
                                placeholder="Min. 8 karakter">
                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-[#4a7a8a] transition-colors">
                                <i :class="showPass ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-rose-500 mt-1.5 font-medium flex items-center"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-[11px] font-bold text-slate-500 tracking-wider uppercase mb-1.5">Konfirmasi Sandi</label>
                        <div class="relative" x-data="{ showConf: false }">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4" :class="password_confirmation.length >= 8 && password === password_confirmation ? 'text-emerald-500' : 'text-slate-400'">
                                <i class="fa-solid fa-lock-open"></i>
                            </span>
                            <input :type="showConf ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" x-model="password_confirmation" required
                                class="w-full bg-slate-50 border rounded-2xl pl-11 pr-10 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none transition-all shadow-sm"
                                :class="password_confirmation.length >= 8 && password === password_confirmation ? 'border-emerald-200 focus:ring-2 focus:ring-emerald-500 focus:bg-white' : 'border-slate-200 focus:ring-2 focus:ring-[#7da8b6] focus:bg-white'"
                                placeholder="Ketik ulang sandi">
                            <button type="button" @click="showConf = !showConf" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-[#4a7a8a] transition-colors">
                                <i :class="showConf ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-3.5 mt-4 bg-[#1a365d] hover:bg-[#2a4a7f] text-white font-bold rounded-2xl tracking-wide shadow-lg shadow-[#1a365d]/20 hover:-translate-y-0.5 transition-all duration-300 cursor-pointer flex justify-center items-center group">
                    <span class="mr-2">Daftarkan Akun</span>
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <!-- Redirection link -->
            <div class="mt-8 text-center text-[13px] text-slate-500 relative z-10 body-font border-t border-slate-100 pt-6">
                Sudah memiliki akun HealthyWay? 
                <a href="/login" class="text-[#4a7a8a] hover:text-[#1a365d] font-bold transition-colors ml-1 underline decoration-2 underline-offset-4 decoration-[#4a7a8a]/30 hover:decoration-[#1a365d]">Masuk sekarang</a>
            </div>
        </div>
    </div>
</body>
</html>
