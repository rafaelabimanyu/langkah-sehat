<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Langkah Sehat</title>
    
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
        /* Custom scrollbar for Glassmorphism */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="bg-gradient-to-tr from-indigo-900 via-slate-950 to-blue-900 min-h-screen text-white base-font flex flex-col md:flex-row antialiased overflow-x-hidden">

    <!-- Mobile Header -->
    <div class="md:hidden flex items-center justify-between px-6 py-4 bg-slate-950/60 backdrop-blur-md border-b border-white/10 z-50">
        <a href="#" class="flex items-center space-x-2">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-cyan-400 to-emerald-400 flex items-center justify-center shadow-lg shadow-cyan-500/30">
                <i class="fa-solid fa-heart-pulse text-slate-950 text-lg"></i>
            </div>
            <span class="font-extrabold text-lg tracking-wider bg-gradient-to-r from-cyan-300 to-emerald-300 bg-clip-text text-transparent">Langkah Sehat</span>
        </a>
        <button id="mobile-menu-toggle" class="text-white hover:text-cyan-400 focus:outline-none transition-colors">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
    </div>

    <!-- Sidebar Container -->
    <aside id="sidebar" class="hidden md:flex flex-col w-full md:w-64 bg-slate-950/40 backdrop-blur-xl border-r border-white/10 min-h-screen p-6 shrink-0 transition-all duration-300">
        <!-- Logo -->
        <div class="flex items-center space-x-3 mb-10">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-400 to-emerald-400 flex items-center justify-center shadow-lg shadow-cyan-500/30">
                <i class="fa-solid fa-heart-pulse text-slate-950 text-xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="font-extrabold text-lg tracking-wider bg-gradient-to-r from-cyan-300 to-emerald-300 bg-clip-text text-transparent">Langkah Sehat</span>
                <span class="text-xs text-white/50 tracking-widest font-semibold uppercase">Self Tracking</span>
            </div>
        </div>

        <!-- User Profile Card -->
        @auth
        <div class="mb-8 p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-cyan-500/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300 font-bold text-lg">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div class="overflow-hidden">
                <h4 class="font-semibold text-sm truncate text-white">{{ Auth::user()->name }}</h4>
                <div class="flex items-center space-x-1.5 mt-0.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-xs text-white/60 capitalize font-medium">{{ Auth::user()->role === 'admin' ? 'Super Admin' : 'Masyarakat' }}</span>
                </div>
            </div>
        </div>
        @endauth

        <!-- Navigation Menu -->
        <nav class="flex-1 space-y-2">
            @auth
                @if(Auth::user()->role === 'masyarakat')
                    <!-- Masyarakat Menu -->
                    <a href="{{ route('masyarakat.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 {{ Route::is('masyarakat.dashboard') ? 'bg-white/15 border-l-4 border-cyan-400 text-white font-semibold shadow-md' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        <i class="fa-solid fa-clock-history text-lg"></i>
                        <span>Riwayat Perjalanan</span>
                    </a>
                    <a href="{{ route('perjalanan.create') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 {{ Route::is('perjalanan.create') ? 'bg-white/15 border-l-4 border-cyan-400 text-white font-semibold shadow-md' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        <i class="fa-solid fa-map-location-dot text-lg"></i>
                        <span>Input Perjalanan</span>
                    </a>
                @elseif(Auth::user()->role === 'admin')
                    <!-- Admin Menu -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 {{ Route::is('admin.dashboard') ? 'bg-white/15 border-l-4 border-cyan-400 text-white font-semibold shadow-md' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        <i class="fa-solid fa-chart-line text-lg"></i>
                        <span>Monitoring Global</span>
                    </a>
                @endif
            @endauth
        </nav>

        <!-- Logout Action -->
        @auth
        <div class="mt-auto pt-6 border-t border-white/10">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-3 rounded-xl bg-rose-500/10 hover:bg-rose-500/25 border border-rose-500/20 text-rose-300 hover:text-white font-semibold transition-all duration-300 hover:-translate-y-0.5 cursor-pointer">
                    <i class="fa-solid fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
        @endauth
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col min-h-screen overflow-y-auto relative">
        
        <!-- Header Banner / Top Bar -->
        <header class="hidden md:flex items-center justify-between px-8 py-5 bg-transparent border-b border-white/5 z-10">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">@yield('page_header', 'Dashboard')</h1>
                <p class="text-xs text-white/50 mt-0.5">Pantau kesehatan diri dan perjalanan Anda secara berkala.</p>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Date display -->
                <div class="text-right hidden lg:block">
                    <p class="text-xs text-white/40">Hari ini</p>
                    <p class="text-sm font-semibold text-white/95">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </header>

        <!-- Dynamic Content Body -->
        <div class="flex-1 p-6 md:p-8 body-font">
            
            <!-- Toast Notifications -->
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform translate-y-2" class="fixed bottom-6 right-6 z-50 bg-emerald-500/20 border border-emerald-500/30 backdrop-blur-lg px-5 py-4 rounded-2xl shadow-xl flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-white/60 hover:text-white transition-colors pl-2">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform translate-y-2" class="fixed bottom-6 right-6 z-50 bg-rose-500/20 border border-rose-500/30 backdrop-blur-lg px-5 py-4 rounded-2xl shadow-xl flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-rose-500/20 text-rose-300 flex items-center justify-center">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-white/60 hover:text-white transition-colors pl-2">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            @endif

            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="mt-auto px-8 py-5 border-t border-white/5 bg-transparent flex flex-col sm:flex-row items-center justify-between text-xs text-white/30">
            <p>&copy; {{ date('Y') }} Langkah Sehat. Seluruh hak cipta dilindungi.</p>
            <p class="mt-1 sm:mt-0">Didesain dengan tema Glassmorphism premium.</p>
        </footer>
    </main>

    <!-- Script for mobile menu toggle -->
    <script>
        document.getElementById('mobile-menu-toggle')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('flex', 'absolute', 'top-[68px]', 'left-0', 'right-0', 'z-50', 'w-full', 'min-h-[calc(100vh-68px)]');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex', 'absolute', 'top-[68px]', 'left-0', 'right-0', 'z-50', 'w-full', 'min-h-[calc(100vh-68px)]');
            }
        });
    </script>
</body>
</html>
