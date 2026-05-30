<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthyWay - Catatan Kesehatan Perjalanan</title>
    
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
        .blur-xs {
            filter: blur(2px);
        }
        .text-shadow-glow {
            text-shadow: 0 0 20px rgba(74, 122, 138, 0.25);
        }
    </style>
</head>
<body class="bg-[#edf3f6] min-h-screen text-[#1e293b] font-sans flex flex-col justify-between antialiased overflow-x-hidden"
      x-data="{ booting: true, heroActive: false }" 
      x-init="window.addEventListener('load', () => { setTimeout(() => booting = false, 700); setTimeout(() => heroActive = true, 950); })">

    <!-- STAGE 1: THE LUXURY CINEMATIC PRE-LOADER CURTAIN -->
    <div class="fixed inset-0 bg-[#edf3f6]/90 backdrop-blur-2xl z-50 flex flex-col items-center justify-center transition-all duration-700 ease-in-out"
         :class="booting ? 'opacity-100' : 'opacity-0 pointer-events-none'">
         <div class="w-20 h-20 rounded-full bg-white/80 border border-slate-200 shadow-xl flex items-center justify-center mb-4 relative">
             <div class="absolute inset-0 rounded-full bg-[#5c8d9d]/20 animate-ping"></div>
             <i class="fa-solid fa-heart-pulse text-[#4a7a8a] text-4xl relative z-10 animate-pulse"></i>
         </div>
         <h2 class="text-xl font-bold text-[#1a365d] tracking-widest animate-pulse">HealthyWay</h2>
    </div>

    <!-- Soft Light Blobs -->
    <div class="absolute top-1/4 left-1/10 w-96 h-96 bg-[#7da8b6]/20 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-1/4 right-1/10 w-96 h-96 bg-[#5c8d9d]/10 rounded-full blur-3xl -z-10"></div>

    <!-- Glassmorphic Navbar -->
    <header class="w-full px-4 sm:px-6 py-4 sm:py-5 bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            <a href="#" class="flex items-center space-x-2 shrink-0">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-[#5c8d9d]/10 flex items-center justify-center border border-[#5c8d9d]/20">
                    <i class="fa-solid fa-heart-pulse text-[#4a7a8a] text-base sm:text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold text-base sm:text-lg tracking-wider text-[#1a365d]">HealthyWay</span>
                    <span class="text-[8px] sm:text-[9px] text-slate-500 tracking-widest font-semibold uppercase -mt-0.5">Self-Tracking App</span>
                </div>
            </a>
            
            <div class="flex items-center space-x-2 sm:space-x-4 shrink-0">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-4 sm:px-6 py-2 sm:py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-full text-xs sm:text-sm font-semibold transition-all duration-300 shadow-sm hover:shadow-md shrink-0">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('masyarakat.dashboard') }}" class="px-4 sm:px-6 py-2 sm:py-2.5 bg-[#4a7a8a] hover:bg-[#3b6370] text-white font-bold rounded-full text-xs sm:text-sm transition-all duration-300 shadow-md hover:shadow-lg shrink-0">
                            Dashboard Saya
                        </a>
                    @endif
                @else
                    <a href="/login" class="px-3 sm:px-6 py-2 sm:py-2.5 bg-white border border-slate-200 hover:bg-slate-50 rounded-full text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-800 transition-all duration-300 shadow-sm shrink-0">
                        Masuk
                    </a>
                    <a href="/register" class="px-3 sm:px-6 py-2.5 bg-[#4a7a8a] hover:bg-[#3b6370] text-white font-bold rounded-full text-xs sm:text-sm transition-all duration-300 shadow-md hover:shadow-lg shrink-0">
                        Daftar Baru
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Hero Area -->
    <main class="max-w-7xl mx-auto px-6 py-12 md:py-20 w-full flex-1 flex flex-col justify-center items-center text-center relative">
        
        <!-- STAGE 2: THE KINETIC CASCADE HERO CONTAINER REVEAL -->
        <div class="w-full max-w-5xl mx-auto transition-all duration-1000 ease-out transform flex flex-col items-center"
             :class="heroActive ? 'opacity-100 scale-100 translate-y-0 filter-none' : 'opacity-0 scale-95 translate-y-12 blur-xs'">
            
            <!-- STAGE 3: STAGGERED CHILD INNER CONTENT INFLOW -->
            <div class="max-w-3xl space-y-6 mb-12 flex flex-col items-center">
                <!-- Top Badge -->
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold text-[#3b6370] bg-[#7da8b6]/20 border border-[#7da8b6]/30 tracking-wider uppercase transition-all duration-700 delay-200 transform"
                      :class="heroActive ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-4'">
                    <i class="fa-solid fa-shield-halved mr-2"></i> {{ __('Aplikasi Pemantauan Mandiri') }}
                </span>
                
                <!-- Main Hero Heading -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight text-[#1a365d] transition-all duration-800 delay-400 transform"
                    :class="heroActive ? 'opacity-100 translate-y-0 text-shadow-glow' : 'opacity-0 translate-y-6'">
                    Satu Langkah Kecil Bersama 
                    <span class="relative inline-block">
                        <span class="absolute inset-0 bg-[#4a7a8a]/20 rounded-lg blur-md transition-opacity duration-1000 delay-500" :class="heroActive ? 'opacity-100' : 'opacity-0'"></span>
                        <span class="relative text-transparent bg-clip-text bg-gradient-to-r from-[#4a7a8a] via-[#5c8d9d] to-[#1a365d] drop-shadow-[0_2px_10px_rgba(74,122,138,0.15)] font-black">HealthyWay</span>
                    </span>
                    untuk Catatan Kesehatan Perjalanan Anda
                </h1>
                
                <!-- Sub-heading Description Text -->
                <p class="text-base sm:text-lg text-slate-600 body-font max-w-2xl mx-auto leading-relaxed transition-all duration-800 delay-600 transform"
                   :class="heroActive ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    Log perjalanan yang mudah, pencatatan suhu tubuh yang akurat, serta pengawasan kesehatan berkala terintegrasi untuk masyarakat yang sehat dan terlindungi.
                </p>
            </div>

            <!-- Real-time Global Counter -->
            <div class="max-w-sm w-full mb-16 transition-all duration-500 delay-800 transform"
                 :class="heroActive ? 'opacity-100 scale-100' : 'opacity-0 scale-90'">
                <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-xl rounded-3xl p-6 hover:shadow-2xl transition-all duration-300">
                    <p class="text-xs font-semibold text-slate-500 tracking-widest uppercase mb-1">Total Log Perjalanan Global</p>
                    <h3 class="text-4xl font-black text-[#4a7a8a] tracking-wider">
                        {{ number_format($totalLogs) }}
                    </h3>
                    <p class="text-[10px] text-slate-400 mt-1.5 body-font">Catatan perjalanan yang telah berhasil dihimpun oleh platform</p>
                </div>
            </div>

        </div>

        <!-- Feature Overview Cards (Scroll-driven reveal & Staggered delay cards) -->
        <div x-data="{ revealed: false }" 
             x-init="window.addEventListener('scroll', () => { if (window.scrollY > $el.offsetTop - window.innerHeight + 150) revealed = true })"
             class="transition-all duration-1000 ease-out transform grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 w-full text-left max-w-6xl body-font"
             :class="revealed ? 'opacity-100 translate-y-0 filter-none' : 'opacity-0 translate-y-12 blur-xs'">
            
            <!-- Feature 1: Quick Logging -->
            <div class="bg-white/70 backdrop-blur-md border border-slate-200 shadow-lg rounded-3xl p-6 transition-all duration-300 hover:-translate-y-1 hover:bg-white group delay-100">
                <div class="w-12 h-12 rounded-full bg-[#5c8d9d]/10 text-[#4a7a8a] flex items-center justify-center mb-5 group-hover:bg-[#5c8d9d]/20 transition-all border border-[#5c8d9d]/20">
                    <i class="fa-solid fa-map-location-dot text-xl"></i>
                </div>
                <h4 class="font-bold text-lg text-[#1e3a5f] mb-2 base-font">Quick Logging</h4>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Catat riwayat perjalanan Anda secara cepat, mudah, dan teratur kapan saja dan di mana saja dalam satu dasbor.
                </p>
            </div>

            <!-- Feature 2: Medical Temp Tracking -->
            <div class="bg-white/70 backdrop-blur-md border border-slate-200 shadow-lg rounded-3xl p-6 transition-all duration-300 hover:-translate-y-1 hover:bg-white group delay-200">
                <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5 group-hover:bg-emerald-100 transition-all border border-emerald-200">
                    <i class="fa-solid fa-temperature-three-quarters text-xl"></i>
                </div>
                <h4 class="font-bold text-lg text-[#1e3a5f] mb-2 base-font">Medical Temp Tracking</h4>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Pantau suhu tubuh dan catatan dokter secara berkala untuk menjaga kesehatan tubuh dan mendapatkan notifikasi peringatan dini.
                </p>
            </div>

            <!-- Feature 3: Secured Privacy -->
            <div class="bg-white/70 backdrop-blur-md border border-slate-200 shadow-lg rounded-3xl p-6 transition-all duration-300 hover:-translate-y-1 hover:bg-white group delay-300">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-5 group-hover:bg-blue-100 transition-all border border-blue-200">
                    <i class="fa-solid fa-user-lock text-xl"></i>
                </div>
                <h4 class="font-bold text-lg text-[#1e3a5f] mb-2 base-font">Secured Privacy</h4>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Data perjalanan pribadi dan catatan konsultasi medis Anda dilindungi secara ketat demi keamanan hak privasi Anda.
                </p>
            </div>

        </div>

    </main>

    <!-- Health Education Hub & FAQ (Scroll-driven reveal) -->
    <section x-data="{ revealed: false }" 
             x-init="window.addEventListener('scroll', () => { if (window.scrollY > $el.offsetTop - window.innerHeight + 150) revealed = true })"
             class="transition-all duration-1000 ease-out transform w-full bg-white/50 border-t border-slate-200 py-16"
             :class="revealed ? 'opacity-100 translate-y-0 filter-none' : 'opacity-0 translate-y-12 blur-xs'">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="text-center mb-12">
                <span class="text-xs font-semibold text-[#4a7a8a] tracking-widest uppercase mb-2 block">Pusat Panduan & Edukasi Sehat Perjalanan</span>
                <h2 class="text-3xl md:text-4xl font-bold text-[#1a365d]">Pahami Tubuh Anda Saat Bepergian</h2>
            </div>

            <!-- Education Grid with Staggered Delays -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 mb-16">
                <!-- Card 1 -->
                <div class="bg-white/80 backdrop-blur-lg border border-white/60 shadow-[0_10px_30px_rgba(148,163,184,0.15)] rounded-3xl p-6 group hover:-translate-y-1 transition-all duration-300 delay-100">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center mb-4 border border-rose-100 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-temperature-arrow-up text-xl"></i>
                    </div>
                    <h3 class="font-bold text-lg text-[#1a365d] mb-2">Panduan Suhu Tubuh Ideal & Deteksi Dini Demam</h3>
                    <p class="text-sm text-slate-600 leading-relaxed body-font">
                        Suhu tubuh normal orang dewasa berada di kisaran 36.1°C hingga 37.2°C. Jika suhu Anda menyentuh 37.5°C atau lebih, tubuh memberikan sinyal awal peringatan.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white/80 backdrop-blur-lg border border-white/60 shadow-[0_10px_30px_rgba(148,163,184,0.15)] rounded-3xl p-6 group hover:-translate-y-1 transition-all duration-300 delay-200">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4 border border-emerald-100 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-person-walking-luggage text-xl"></i>
                    </div>
                    <h3 class="font-bold text-lg text-[#1a365d] mb-2">Tips Menjaga Kondisi Fisik Selama Perjalanan Jauh</h3>
                    <p class="text-sm text-slate-600 leading-relaxed body-font">
                        Perbanyak minum air putih, hindari dehidrasi, dan lakukan peregangan setiap 2 jam. Jaga pola tidur agar imunitas tidak drop selama bepergian.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white/80 backdrop-blur-lg border border-white/60 shadow-[0_10px_30px_rgba(148,163,184,0.15)] rounded-3xl p-6 group hover:-translate-y-1 transition-all duration-300 delay-300">
                    <div class="w-12 h-12 rounded-xl bg-[#5c8d9d]/10 text-[#4a7a8a] flex items-center justify-center mb-4 border border-[#5c8d9d]/20 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-file-medical text-xl"></i>
                    </div>
                    <h3 class="font-bold text-lg text-[#1a365d] mb-2">Mengapa Mencatat Riwayat Bisa Menyelamatkan Anda</h3>
                    <p class="text-sm text-slate-600 leading-relaxed body-font">
                        Contact tracing dan catatan kronologis mempermudah tenaga medis mendiagnosis jika Anda jatuh sakit pasca-perjalanan. Sebuah kebiasaan kecil yang krusial.
                    </p>
                </div>
            </div>

            <!-- Interactive FAQ Section -->
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-[#1a365d]">Pertanyaan yang Sering Diajukan</h3>
                </div>
                
                <div class="space-y-4" x-data="{ active: null }">
                    <!-- FAQ 1 -->
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm transition-all duration-300">
                        <button @click="active = (active === 1 ? null : 1)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                            <span class="font-semibold text-[#1a365d]">Apakah data perjalanan saya aman?</span>
                            <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300" :class="active === 1 ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="active === 1" x-collapse>
                            <div class="px-6 pb-4 text-sm text-slate-600 body-font">
                                Sangat aman. HealthyWay menggunakan enkripsi standar industri. Data hanya digunakan untuk pemantauan kesehatan pribadi dan rekapitulasi medis Anda sendiri.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 2 -->
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm transition-all duration-300">
                        <button @click="active = (active === 2 ? null : 2)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                            <span class="font-semibold text-[#1a365d]">Bagaimana jika saya lupa mencatat perjalanan?</span>
                            <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300" :class="active === 2 ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="active === 2" x-collapse>
                            <div class="px-6 pb-4 text-sm text-slate-600 body-font">
                                Tidak masalah! Anda dapat menambahkan log perjalanan secara retrospektif (mundur) dengan memilih tanggal dan jam yang sesuai saat Anda tiba di lokasi.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 3 -->
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm transition-all duration-300">
                        <button @click="active = (active === 3 ? null : 3)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                            <span class="font-semibold text-[#1a365d]">Bisakah saya mencetak data untuk dibawa ke dokter?</span>
                            <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300" :class="active === 3 ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="active === 3" x-collapse>
                            <div class="px-6 pb-4 text-sm text-slate-600 body-font">
                                Tentu. HealthyWay menyediakan fitur "Cetak Riwayat PDF" di dashboard Anda. Format cetakannya sudah didesain khusus agar mudah dibaca oleh tenaga medis.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="w-full px-6 py-6 border-t border-slate-200 text-center text-xs text-slate-500 body-font bg-white/50">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between">
            <p>&copy; {{ date('Y') }} HealthyWay. Seluruh hak cipta dilindungi.</p>
            <p class="mt-1 sm:mt-0">Premium Light Medical Design.</p>
        </div>
    </footer>

</body>
</html>
