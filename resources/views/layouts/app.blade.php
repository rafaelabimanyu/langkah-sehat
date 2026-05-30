<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - HealthyWay</title>
    
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
            font-family: 'Outfit', 'Inter', sans-serif;
        }
        .body-font {
            font-family: 'Inter', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-[#edf3f6] min-h-screen text-[#1e293b] font-sans antialiased flex overflow-x-hidden {{ Auth::check() && Auth::user()->role === 'admin' ? 'flex-col md:flex-row' : 'flex-col' }}" x-data="{ helpModalOpen: false }">

    @auth
        @if(Auth::user()->role === 'masyarakat')
            <!-- PREMIUM LIGHT FLOATING NAVIGATION BAR FOR MASYARAKAT -->
            <header class="w-full mt-4 px-4 sm:px-6 lg:px-8 sticky top-4 z-50 transition-all duration-300" x-data="{ mobileOpen: false }">
                <div class="max-w-7xl mx-auto bg-white/80 backdrop-blur-lg border border-white/60 shadow-[0_10px_30px_rgba(148,163,184,0.15)] rounded-full px-6 py-3 h-16 flex items-center justify-between">
                    
                    <!-- Brand Logo -->
                    <a href="{{ route('masyarakat.dashboard') }}" class="flex items-center space-x-2.5 shrink-0">
                        <div class="w-9 h-9 rounded-full bg-[#5c8d9d]/10 flex items-center justify-center border border-[#5c8d9d]/20">
                            <i class="fa-solid fa-heart-pulse text-[#4a7a8a] text-base"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-base tracking-wider text-[#1a365d]">HealthyWay</span>
                            <span class="text-[9px] text-slate-500 tracking-widest font-semibold uppercase -mt-0.5">Masyarakat Panel</span>
                        </div>
                    </a>

                    <!-- Center Nav Links (Desktop) -->
                    <nav class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('masyarakat.dashboard') }}" class="flex items-center space-x-2 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ Route::is('masyarakat.dashboard') ? 'bg-[#5c8d9d]/10 text-[#1a365d] shadow-sm' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                            <i class="fa-solid fa-house text-xs"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('perjalanan.create') }}" class="flex items-center space-x-2 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ Route::is('perjalanan.create') ? 'bg-[#5c8d9d]/10 text-[#1a365d] shadow-sm' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span>Catat Perjalanan</span>
                        </a>
                        <a href="{{ route('perjalanan.riwayat') }}" class="flex items-center space-x-2 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ Route::is('perjalanan.riwayat') ? 'bg-[#5c8d9d]/10 text-[#1a365d] shadow-sm' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                            <i class="fa-solid fa-calendar-days text-xs"></i>
                            <span>Riwayat Log</span>
                        </a>
                    </nav>

                    <!-- Right Side: User Profile & Logout -->
                    <div class="flex items-center space-x-3">
                        <button @click="helpModalOpen = true" class="hidden sm:flex items-center space-x-1.5 px-4 py-2 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-800 text-xs font-bold transition-all duration-300">
                            <i class="fa-solid fa-circle-question"></i>
                            <span>Panduan</span>
                        </button>
                        <div class="hidden lg:flex items-center space-x-3 pr-3 border-r border-slate-200 ml-2">
                            <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-[#4a7a8a] font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <span class="text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" class="m-0 hidden sm:block">
                            @csrf
                            <button type="submit" class="flex items-center space-x-1.5 px-4 py-2 rounded-full bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold transition-all duration-300 hover:-translate-y-0.5 cursor-pointer">
                                <i class="fa-solid fa-sign-out-alt"></i>
                                <span>Keluar</span>
                            </button>
                        </form>

                        <!-- Mobile Menu Toggle -->
                        <button @click="mobileOpen = !mobileOpen" class="md:hidden text-slate-500 hover:text-[#4a7a8a] transition-colors p-2">
                            <i class="fa-solid" :class="mobileOpen ? 'fa-xmark' : 'fa-bars'" class="text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation Dropdown -->
                <div x-show="mobileOpen" x-transition class="md:hidden mt-2 bg-white/95 backdrop-blur-xl border border-slate-200 shadow-xl rounded-3xl px-4 py-4 space-y-1" style="display: none;">
                    <a href="{{ route('masyarakat.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-full text-sm font-semibold {{ Route::is('masyarakat.dashboard') ? 'bg-[#5c8d9d]/10 text-[#1a365d]' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('perjalanan.create') }}" class="flex items-center space-x-3 px-4 py-3 rounded-full text-sm font-semibold {{ Route::is('perjalanan.create') ? 'bg-[#5c8d9d]/10 text-[#1a365d]' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-plus"></i>
                        <span>Catat Perjalanan</span>
                    </a>
                    <a href="{{ route('perjalanan.riwayat') }}" class="flex items-center space-x-3 px-4 py-3 rounded-full text-sm font-semibold {{ Route::is('perjalanan.riwayat') ? 'bg-[#5c8d9d]/10 text-[#1a365d]' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Riwayat Log & Analisis</span>
                    </a>
                    <button @click="helpModalOpen = true; mobileOpen = false" class="w-full flex items-center space-x-3 px-4 py-3 rounded-full text-sm font-semibold text-slate-600 hover:bg-slate-50 text-left">
                        <i class="fa-solid fa-circle-question"></i>
                        <span>Panduan Penggunaan</span>
                    </button>
                    <div class="border-t border-slate-100 pt-2 mt-2">
                        <div class="flex items-center space-x-3 px-4 py-2">
                            <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-[#4a7a8a] font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <span class="text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="mt-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-full bg-rose-50 text-rose-600 text-sm font-bold transition-all cursor-pointer hover:bg-rose-100">
                                <i class="fa-solid fa-sign-out-alt"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>
        @else
            <!-- ADMIN VIEW: RETAIN SIDEBAR LAYOUT BUT LIGHT THEME -->
            <!-- Mobile Header for Admin -->
            <div class="md:hidden flex items-center justify-between px-6 py-4 bg-white/90 backdrop-blur-md border-b border-slate-200 z-50">
                <a href="#" class="flex items-center space-x-2">
                    <div class="w-9 h-9 rounded-full bg-[#5c8d9d]/10 flex items-center justify-center">
                        <i class="fa-solid fa-heart-pulse text-[#4a7a8a] text-lg"></i>
                    </div>
                    <span class="font-extrabold text-lg tracking-wider text-[#1a365d]">HealthyWay</span>
                </a>
                <button id="mobile-menu-toggle" class="text-slate-600 hover:text-[#4a7a8a] focus:outline-none transition-colors">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Admin Sidebar -->
            <aside id="sidebar" class="hidden md:flex flex-col w-full md:w-72 bg-white/80 backdrop-blur-xl border-r border-slate-200 min-h-screen p-6 shrink-0 transition-all duration-300">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mb-10 pl-2">
                    <div class="w-10 h-10 rounded-full bg-[#5c8d9d]/10 flex items-center justify-center border border-[#5c8d9d]/20">
                        <i class="fa-solid fa-heart-pulse text-[#4a7a8a] text-xl"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-lg tracking-wider text-[#1a365d]">HealthyWay</span>
                        <span class="text-xs text-slate-400 tracking-widest font-semibold uppercase">Super Admin</span>
                    </div>
                </div>

                <!-- User Profile Card -->
                <div class="mb-8 p-4 rounded-3xl bg-slate-50 border border-slate-100 flex items-center space-x-3 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-[#edf3f6] flex items-center justify-center text-[#4a7a8a] font-bold text-lg">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="font-semibold text-sm truncate text-slate-800">{{ Auth::user()->name }}</h4>
                        <div class="flex items-center space-x-1.5 mt-0.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-xs text-slate-500 capitalize font-medium">Administrator</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-full transition-all duration-300 {{ Route::is('admin.dashboard') ? 'bg-[#5c8d9d]/10 text-[#1a365d] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
                        <i class="fa-solid fa-chart-line text-lg w-6 text-center"></i>
                        <span>Monitoring Global</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 px-4 py-3 rounded-full transition-all duration-300 {{ Route::is('admin.users') ? 'bg-[#5c8d9d]/10 text-[#1a365d] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
                        <i class="fa-solid fa-users-gear text-lg w-6 text-center"></i>
                        <span>Kelola Pengguna</span>
                    </a>
                </nav>

                <!-- Help Guide -->
                <div class="mt-4 mb-2">
                    <button @click="helpModalOpen = true" class="w-full flex items-center space-x-3 px-4 py-3 rounded-full transition-all duration-300 text-slate-500 hover:bg-slate-100 hover:text-slate-800 border border-transparent hover:border-slate-200">
                        <i class="fa-solid fa-circle-question text-lg w-6 text-center"></i>
                        <span>Panduan Sistem</span>
                    </button>
                </div>

                <!-- Logout Action -->
                <div class="mt-auto pt-6 border-t border-slate-200">
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-3 rounded-full bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 font-semibold transition-all duration-300 hover:-translate-y-0.5 cursor-pointer">
                            <i class="fa-solid fa-sign-out-alt"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </aside>
        @endif
    @endauth

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col min-h-screen overflow-y-auto relative">
        
        <!-- Header Banner for Admin only -->
        @auth
            @if(Auth::user()->role === 'admin')
                <header class="hidden md:flex items-center justify-between px-8 py-6 bg-transparent border-b border-slate-200 z-10">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-[#1a365d]">@yield('page_header', 'Dashboard')</h1>
                        <p class="text-xs text-slate-500 mt-1">Panel pemantauan global untuk data log perjalanan masyarakat.</p>
                    </div>
                    
                    <div class="text-right hidden lg:block">
                        <p class="text-xs text-slate-400 font-medium">Hari ini</p>
                        <p class="text-sm font-semibold text-slate-700">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </header>
            @endif
        @endauth

        <!-- Dynamic Content Body -->
        <div class="flex-1 p-4 sm:p-6 md:p-8 {{ Auth::check() && Auth::user()->role === 'masyarakat' ? 'max-w-7xl mx-auto w-full' : '' }} body-font">
            
            <!-- Toast Notifications -->
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform translate-y-2" class="fixed bottom-6 right-6 z-50 bg-emerald-100 border border-emerald-200 px-5 py-4 rounded-3xl shadow-xl flex items-center space-x-3">
                <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-600 hover:text-emerald-800 transition-colors pl-2">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform translate-y-2" class="fixed bottom-6 right-6 z-50 bg-rose-100 border border-rose-200 px-5 py-4 rounded-3xl shadow-xl flex items-center space-x-3">
                <div class="w-8 h-8 rounded-full bg-rose-500 text-white flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-rose-800">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-rose-600 hover:text-rose-800 transition-colors pl-2">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            @endif

            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="mt-auto px-8 py-6 border-t border-slate-200 bg-transparent flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 {{ Auth::check() && Auth::user()->role === 'masyarakat' ? 'max-w-7xl mx-auto w-full' : '' }}">
            <p>&copy; {{ date('Y') }} HealthyWay. Seluruh hak cipta dilindungi.</p>
            <p class="mt-1 sm:mt-0">Premium Light Medical Design.</p>
        </footer>
    </main>

    <!-- Script for mobile menu toggle (Admin only) -->
    <script>
        document.getElementById('mobile-menu-toggle')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('flex', 'absolute', 'top-[68px]', 'left-0', 'right-0', 'z-50', 'w-full', 'min-h-[calc(100vh-68px)]', 'bg-white');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex', 'absolute', 'top-[68px]', 'left-0', 'right-0', 'z-50', 'w-full', 'min-h-[calc(100vh-68px)]', 'bg-white');
            }
        });
    </script>

    <!-- Global Help Documentation Modal -->
    <div x-show="helpModalOpen" 
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-slate-900/40 backdrop-blur-sm">
         
        <div class="w-full max-w-2xl max-h-[85vh] flex flex-col bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden transform transition-all"
             @click.away="helpModalOpen = false">
             
            <!-- Header -->
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50 shrink-0">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-[#5c8d9d]/10 text-[#4a7a8a] flex items-center justify-center">
                        <i class="fa-solid fa-book-open-reader text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-[#1a365d] tracking-tight">Pusat Bantuan & Panduan</h3>
                        <p class="text-[10px] text-slate-500">Dokumentasi operasional HealthyWay</p>
                    </div>
                </div>
                <button @click="helpModalOpen = false" class="text-slate-400 hover:text-slate-700 hover:bg-slate-200 p-2 rounded-full transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-6 overflow-y-auto body-font text-sm text-slate-700 space-y-6">
                
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <!-- ADMIN GUIDE -->
                    <div>
                        <h4 class="text-[#1e3a5f] font-bold text-base mb-2 flex items-center"><i class="fa-solid fa-shield-halved mr-2 text-[#4a7a8a]"></i>Panduan Administrator</h4>
                        <p class="mb-3 leading-relaxed">Sebagai admin, tugas Anda adalah memantau pergerakan dan status kesehatan masyarakat secara global.</p>
                        
                        <div class="space-y-4">
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                                <h5 class="text-[#1a365d] font-bold mb-1"><i class="fa-solid fa-chart-line text-[#4a7a8a] mr-2"></i>Monitoring Global</h5>
                                <p class="text-[12px] text-slate-600">Lihat ringkasan total pengguna, total log, dan jumlah alert (suhu &ge; 37.5&deg;C). Tabel di bawahnya menampilkan seluruh log secara real-time. Gunakan filter tanggal, suhu, dan pencarian untuk mengaudit data.</p>
                            </div>
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                                <h5 class="text-[#1a365d] font-bold mb-1"><i class="fa-solid fa-users-gear text-[#4a7a8a] mr-2"></i>Kelola Pengguna</h5>
                                <p class="text-[12px] text-slate-600">Fitur untuk melihat semua akun terdaftar. Anda memiliki akses untuk menghapus pengguna jika terindikasi spam atau melanggar aturan sistem.</p>
                            </div>
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                                <h5 class="text-[#1a365d] font-bold mb-1"><i class="fa-solid fa-trash-can text-rose-500 mr-2"></i>Hapus Log Anomalus</h5>
                                <p class="text-[12px] text-slate-600">Melalui tabel monitoring, Anda dapat menghapus entri perjalanan masyarakat yang dianggap anomali/palsu demi menjaga kebersihan data global.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- MASYARAKAT GUIDE -->
                    <div>
                        <h4 class="text-[#1e3a5f] font-bold text-base mb-2 flex items-center"><i class="fa-solid fa-user-check mr-2 text-[#4a7a8a]"></i>Panduan Pengguna (Masyarakat)</h4>
                        <p class="mb-3 leading-relaxed">Gunakan aplikasi ini untuk mencatat histori perjalanan dan kondisi suhu tubuh Anda sehari-hari.</p>
                        
                        <div class="space-y-4">
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                                <h5 class="text-[#1a365d] font-bold mb-1"><i class="fa-solid fa-plus text-[#4a7a8a] mr-2"></i>Catat Perjalanan</h5>
                                <p class="text-[12px] text-slate-600">Klik menu <strong>Catat Perjalanan</strong>. Waktu dan tanggal otomatis terisi, namun Anda bisa mengubahnya. Masukkan lokasi, suhu tubuh (normal: &lt; 37.5&deg;C), dan catatan keluhan bila ada.</p>
                            </div>
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                                <h5 class="text-[#1a365d] font-bold mb-1"><i class="fa-solid fa-calendar-days text-[#4a7a8a] mr-2"></i>Riwayat & Ekspor Log</h5>
                                <p class="text-[12px] text-slate-600">Menu <strong>Riwayat Log</strong> menampilkan semua catatan Anda. Jika Anda ingin berkonsultasi ke dokter, gunakan tombol <strong>Cetak Riwayat PDF/Print</strong> untuk mencetak laporan resmi.</p>
                            </div>
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                                <h5 class="text-[#1a365d] font-bold mb-1"><i class="fa-solid fa-heart-pulse text-rose-500 mr-2"></i>Indikator Suhu (Demam)</h5>
                                <p class="text-[12px] text-slate-600">Jika Anda memasukkan suhu tubuh 37.5&deg;C atau lebih, sistem akan menandainya dengan status <span class="text-rose-600 font-semibold">Demam (Alert merah)</span>. Segera istirahat dan kunjungi fasilitas medis jika memburuk.</p>
                            </div>
                        </div>
                    </div>
                @endif
                
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-5 border-t border-slate-100 bg-slate-50 flex justify-end shrink-0">
                <button @click="helpModalOpen = false" class="px-6 py-2.5 rounded-full bg-[#4a7a8a] hover:bg-[#3b6370] text-white font-semibold transition-all text-sm cursor-pointer shadow-md">
                    Mengerti, Tutup
                </button>
            </div>
        </div>
    </div>
</body>
</html>
