<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Langkah Sehat - Catatan Kesehatan Perjalanan</title>
    
    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
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
<body class="bg-gradient-to-tr from-indigo-900 via-slate-950 to-blue-900 min-h-screen text-white base-font flex flex-col justify-between antialiased overflow-x-hidden">

    <!-- Glowing Background blobs -->
    <div class="absolute top-1/4 left-1/10 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-1/4 right-1/10 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl -z-10"></div>

    <!-- Glassmorphic Navbar -->
    <header class="w-full px-6 py-5 bg-white/5 backdrop-blur-md border-b border-white/10 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="#" class="flex items-center space-x-2.5">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-400 to-emerald-400 flex items-center justify-center shadow-lg shadow-cyan-500/30">
                    <i class="fa-solid fa-heart-pulse text-slate-950 text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold text-lg tracking-wider bg-gradient-to-r from-cyan-300 to-emerald-300 bg-clip-text text-transparent">Langkah Sehat</span>
                    <span class="text-[9px] text-white/50 tracking-widest font-semibold uppercase -mt-0.5">Self-Tracking App</span>
                </div>
            </a>
            
            <div class="flex items-center space-x-4">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('masyarakat.dashboard') }}" class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-emerald-500 hover:from-cyan-600 hover:to-emerald-600 text-slate-950 font-bold rounded-xl text-sm transition-all duration-300 hover:-translate-y-0.5 shadow-lg shadow-cyan-500/25">
                            Dashboard Saya
                        </a>
                    @endif
                @else
                    <a href="/login" class="px-5 py-2.5 bg-white/5 hover:bg-white/15 border border-white/10 rounded-xl text-sm font-semibold text-white/80 hover:text-white transition-all duration-300 hover:-translate-y-0.5">
                        Masuk
                    </a>
                    <a href="/register" class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-emerald-500 hover:from-cyan-600 hover:to-emerald-600 text-slate-950 font-bold rounded-xl text-sm transition-all duration-300 hover:-translate-y-0.5 shadow-lg shadow-cyan-500/25">
                        Daftar Baru
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Hero Area -->
    <main class="max-w-7xl mx-auto px-6 py-12 md:py-20 w-full flex-1 flex flex-col justify-center items-center text-center relative">
        
        <!-- Hero Text -->
        <div class="max-w-3xl space-y-6 mb-12">
            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold text-cyan-300 bg-cyan-500/10 border border-cyan-500/20 tracking-wider uppercase">
                <i class="fa-solid fa-shield-halved mr-2"></i> Aplikasi Pemantauan Mandiri
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight leading-tight">
                Satu Langkah Kecil untuk <br class="hidden sm:inline">
                <span class="bg-gradient-to-r from-cyan-300 via-emerald-300 to-teal-300 bg-clip-text text-transparent">Catatan Kesehatan Perjalanan</span> Anda
            </h1>
            <p class="text-base sm:text-lg text-white/60 body-font max-w-2xl mx-auto leading-relaxed">
                Log perjalanan yang mudah, pencatatan suhu tubuh yang akurat, serta pengawasan kesehatan berkala terintegrasi untuk masyarakat yang sehat dan terlindungi.
            </p>
        </div>

        <!-- Real-time Global Counter -->
        <div class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl p-6 max-w-sm w-full mb-16 hover:border-white/30 transition-all duration-300">
            <p class="text-xs font-semibold text-white/50 tracking-widest uppercase mb-1">Total Log Perjalanan Global</p>
            <h3 class="text-4xl font-black text-cyan-300 tracking-wider">
                {{ number_format($totalLogs) }}
            </h3>
            <p class="text-[10px] text-white/30 mt-1.5 body-font">Catatan perjalanan yang telah berhasil dihimpun oleh platform</p>
        </div>

        <!-- Feature Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full text-left max-w-6xl body-font">
            
            <!-- Feature 1: Quick Logging -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 hover:border-white/20 shadow-lg rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:bg-white/10 group">
                <div class="w-12 h-12 rounded-xl bg-cyan-500/20 text-cyan-300 flex items-center justify-center mb-5 group-hover:bg-cyan-500/30 transition-all">
                    <i class="fa-solid fa-map-location-dot text-xl"></i>
                </div>
                <h4 class="font-bold text-lg text-white mb-2 base-font">Quick Logging</h4>
                <p class="text-sm text-white/60 leading-relaxed">
                    Catat riwayat perjalanan Anda secara cepat, mudah, dan teratur kapan saja dan di mana saja dalam satu dasbor.
                </p>
            </div>

            <!-- Feature 2: Medical Temp Tracking -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 hover:border-white/20 shadow-lg rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:bg-white/10 group">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center mb-5 group-hover:bg-emerald-500/30 transition-all">
                    <i class="fa-solid fa-temperature-three-quarters text-xl"></i>
                </div>
                <h4 class="font-bold text-lg text-white mb-2 base-font">Medical Temp Tracking</h4>
                <p class="text-sm text-white/60 leading-relaxed">
                    Pantau suhu tubuh dan catatan dokter secara berkala untuk menjaga kesehatan tubuh dan mendapatkan notifikasi peringatan dini.
                </p>
            </div>

            <!-- Feature 3: Secured Privacy -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 hover:border-white/20 shadow-lg rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:bg-white/10 group">
                <div class="w-12 h-12 rounded-xl bg-blue-500/20 text-blue-300 flex items-center justify-center mb-5 group-hover:bg-blue-500/30 transition-all">
                    <i class="fa-solid fa-user-lock text-xl"></i>
                </div>
                <h4 class="font-bold text-lg text-white mb-2 base-font">Secured Privacy</h4>
                <p class="text-sm text-white/60 leading-relaxed">
                    Data perjalanan pribadi dan catatan konsultasi medis Anda dilindungi secara ketat demi keamanan hak privasi Anda.
                </p>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full px-6 py-6 border-t border-white/5 text-center text-xs text-white/30 body-font">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between">
            <p>&copy; {{ date('Y') }} Langkah Sehat. Seluruh hak cipta dilindungi.</p>
            <p class="mt-1 sm:mt-0">Premium Glassmorphism Design.</p>
        </div>
    </footer>

</body>
</html>
