@extends('layouts.app')

@section('title', 'Dashboard Kesehatan')

@section('content')
<div class="space-y-8">

    <!-- GREETING CARD WITH ANIMATED HEART -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300 hover:border-white/30">
        
        <!-- Decorative Glow Elements -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-gradient-to-tr from-cyan-400 to-emerald-400 rounded-full opacity-20 blur-2xl animate-pulse"></div>
        <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-indigo-500/15 rounded-full blur-2xl"></div>
        
        <!-- Pulsing Health Heart Icon -->
        <div class="absolute top-6 right-6 sm:top-8 sm:right-8">
            <div class="relative">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-cyan-500/20 to-emerald-500/20 border border-cyan-400/20 flex items-center justify-center shadow-[0_0_30px_rgba(6,182,212,0.2)]">
                    <i class="fa-solid fa-heart-pulse text-3xl text-cyan-400 animate-pulse"></i>
                </div>
                <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-emerald-500 border-2 border-slate-950 flex items-center justify-center">
                    <i class="fa-solid fa-check text-[8px] text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="relative z-10 pr-20 sm:pr-24">
            <p class="text-xs text-white/40 font-semibold tracking-widest uppercase mb-1">Selamat Datang</p>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight bg-gradient-to-r from-white to-white/70 bg-clip-text text-transparent">Halo, {{ Auth::user()->name }}!</h1>
            <p class="text-sm text-white/50 mt-2 body-font leading-relaxed max-w-lg">Portal pelacakan perjalanan & suhu tubuh pribadi Anda. Pantau kondisi kesehatan dan buat catatan harian dengan mudah.</p>
            
            <div class="mt-5 inline-flex items-center space-x-2">
                <span class="text-xs font-semibold text-white/60 tracking-wider">Status:</span>
                @if($healthStatus === 'Normal')
                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold text-emerald-300 bg-emerald-500/20 border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.25)]">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 mr-2 animate-pulse"></span>Normal
                    </span>
                @elseif($healthStatus === 'Belum Ada Data')
                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold text-white/70 bg-white/10 border border-white/10">
                        <span class="w-2 h-2 rounded-full bg-white/40 mr-2"></span>Belum Ada Data
                    </span>
                @else
                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold text-rose-300 bg-rose-500/20 border border-rose-500/30 shadow-[0_0_15px_rgba(244,63,94,0.4)] animate-pulse">
                        <span class="w-2 h-2 rounded-full bg-rose-400 mr-2"></span>{{ $healthStatus }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- QUICK SUMMARY METRICS + ACTIONS ROW -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Perjalanan -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-5 relative overflow-hidden transition-all duration-300 hover:border-white/30 hover:-translate-y-0.5 group">
            <div class="absolute -bottom-6 -right-6 w-16 h-16 bg-cyan-500/10 rounded-full blur-xl group-hover:bg-cyan-500/20 transition-all"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-500/20 text-cyan-300 flex items-center justify-center border border-cyan-500/30 shadow-[0_0_12px_rgba(6,182,212,0.2)]">
                    <i class="fa-solid fa-route text-lg"></i>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold text-cyan-300 bg-cyan-500/15 border border-cyan-500/20 uppercase tracking-widest">Log</span>
            </div>
            <p class="text-[10px] font-semibold text-white/40 uppercase tracking-widest">Total Perjalanan</p>
            <p class="text-3xl font-black text-white tracking-tight mt-1">{{ $totalLogs }}</p>
        </div>

        <!-- Rata-Rata Suhu -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-5 relative overflow-hidden transition-all duration-300 hover:border-white/30 hover:-translate-y-0.5 group">
            <div class="absolute -bottom-6 -right-6 w-16 h-16 bg-emerald-500/10 rounded-full blur-xl group-hover:bg-emerald-500/20 transition-all"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center border border-emerald-500/30 shadow-[0_0_12px_rgba(16,185,129,0.2)]">
                    <i class="fa-solid fa-temperature-half text-lg"></i>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold text-emerald-300 bg-emerald-500/15 border border-emerald-500/20 uppercase tracking-widest">Avg</span>
            </div>
            <p class="text-[10px] font-semibold text-white/40 uppercase tracking-widest">Rata-Rata Suhu</p>
            @if($avgTemp > 0)
                <p class="text-3xl font-black text-emerald-400 tracking-tight mt-1">{{ number_format($avgTemp, 1) }}<span class="text-lg">°C</span></p>
            @else
                <p class="text-3xl font-black text-white/30 tracking-tight mt-1">—</p>
            @endif
        </div>

        <!-- Quick Action: Catat Perjalanan -->
        <a href="{{ route('perjalanan.create') }}" class="bg-gradient-to-br from-cyan-500/20 to-emerald-500/20 backdrop-blur-xl border border-cyan-400/30 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-5 relative overflow-hidden transition-all duration-300 hover:border-cyan-400/50 hover:-translate-y-1 hover:shadow-[0_0_25px_rgba(6,182,212,0.2)] group block">
            <div class="absolute -bottom-6 -right-6 w-16 h-16 bg-cyan-500/10 rounded-full blur-xl group-hover:bg-cyan-500/25 transition-all"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-500/30 text-white flex items-center justify-center border border-cyan-400/40 shadow-[0_0_15px_rgba(6,182,212,0.3)]">
                    <i class="fa-solid fa-plus text-lg"></i>
                </div>
                <i class="fa-solid fa-arrow-right text-white/30 group-hover:text-cyan-300 group-hover:translate-x-1 transition-all"></i>
            </div>
            <p class="text-[10px] font-semibold text-white/40 uppercase tracking-widest">Aksi Cepat</p>
            <p class="text-lg font-bold text-white mt-1">Catat Perjalanan</p>
        </a>

        <!-- Quick Action: Lihat Riwayat -->
        <a href="{{ route('perjalanan.riwayat') }}" class="bg-gradient-to-br from-indigo-500/20 to-violet-500/20 backdrop-blur-xl border border-indigo-400/30 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-5 relative overflow-hidden transition-all duration-300 hover:border-indigo-400/50 hover:-translate-y-1 hover:shadow-[0_0_25px_rgba(99,102,241,0.2)] group block">
            <div class="absolute -bottom-6 -right-6 w-16 h-16 bg-indigo-500/10 rounded-full blur-xl group-hover:bg-indigo-500/25 transition-all"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/30 text-white flex items-center justify-center border border-indigo-400/40 shadow-[0_0_15px_rgba(99,102,241,0.3)]">
                    <i class="fa-solid fa-calendar-days text-lg"></i>
                </div>
                <i class="fa-solid fa-arrow-right text-white/30 group-hover:text-indigo-300 group-hover:translate-x-1 transition-all"></i>
            </div>
            <p class="text-[10px] font-semibold text-white/40 uppercase tracking-widest">Aksi Cepat</p>
            <p class="text-lg font-bold text-white mt-1">Riwayat Log</p>
        </a>
    </div>

    <!-- HEALTH TRENDS WIDGET: Grafik Tren Suhu Mingguan -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300 hover:border-white/30">
        <div class="absolute -top-10 -right-10 w-24 h-24 bg-cyan-500/10 rounded-full blur-2xl"></div>
        
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-500/20 text-indigo-300 flex items-center justify-center border border-indigo-500/30 shadow-[0_0_12px_rgba(99,102,241,0.2)]">
                    <i class="fa-solid fa-chart-line text-base"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-white">Grafik Tren Suhu Mingguan</h3>
                    <p class="text-[10px] text-white/40 mt-0.5">Rata-rata suhu tubuh 7 hari terakhir</p>
                </div>
            </div>
            <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-full text-[9px] font-bold text-indigo-300 bg-indigo-500/15 border border-indigo-500/20 uppercase tracking-widest">Weekly</span>
        </div>

        <!-- Temperature Bar Chart -->
        <div class="flex items-end justify-between space-x-2 sm:space-x-4 h-44 sm:h-52">
            @foreach($weeklyTemps as $day)
                <div class="flex-1 flex flex-col items-center space-y-2 group">
                    <!-- Temperature Label -->
                    <span class="text-[10px] font-bold {{ $day['temp'] ? ($day['temp'] >= 37.5 ? 'text-rose-400' : 'text-cyan-300') : 'text-white/30' }} opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        {{ $day['temp'] ? number_format($day['temp'], 1) . '°' : '-' }}
                    </span>
                    
                    <!-- Bar -->
                    @php
                        $barHeight = 0;
                        if ($day['temp']) {
                            // Map temperature (35-40) to percentage (10-100)
                            $barHeight = max(10, min(100, (($day['temp'] - 35) / 5) * 100));
                        }
                        $barColor = !$day['temp'] ? 'from-white/5 to-white/10' : ($day['temp'] >= 37.5 ? 'from-rose-500 to-rose-400' : 'from-cyan-500 to-emerald-400');
                    @endphp
                    <div class="w-full rounded-xl bg-white/5 border border-white/10 overflow-hidden relative flex items-end" style="height: 100%;">
                        <div class="w-full rounded-xl bg-gradient-to-t {{ $barColor }} transition-all duration-700 ease-out group-hover:opacity-90 {{ $day['temp'] && $day['temp'] >= 37.5 ? 'animate-pulse' : '' }}"
                             style="height: {{ $day['temp'] ? $barHeight : 5 }}%; min-height: 4px;">
                        </div>
                    </div>
                    
                    <!-- Day Label -->
                    <div class="text-center">
                        <span class="text-[10px] font-bold text-white/60 block">{{ $day['day'] }}</span>
                        <span class="text-[8px] text-white/30 block">{{ $day['date'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Legend -->
        <div class="flex items-center justify-center space-x-6 mt-5 pt-4 border-t border-white/5">
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 rounded-sm bg-gradient-to-r from-cyan-500 to-emerald-400"></div>
                <span class="text-[10px] text-white/50 font-medium">Normal (< 37.5°C)</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 rounded-sm bg-gradient-to-r from-rose-500 to-rose-400"></div>
                <span class="text-[10px] text-white/50 font-medium">Demam (≥ 37.5°C)</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 rounded-sm bg-white/10 border border-white/20"></div>
                <span class="text-[10px] text-white/50 font-medium">Tidak Ada Data</span>
            </div>
        </div>
    </div>

    <!-- RECENT ACTIVITY FEED (Quick Glance of Last 3 Logs) -->
    @if($recentLogs->count() > 0)
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-6 relative overflow-hidden transition-all duration-300 hover:border-white/30">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-lg bg-amber-500/20 text-amber-300 flex items-center justify-center border border-amber-500/30 shadow-[0_0_12px_rgba(245,158,11,0.2)]">
                    <i class="fa-solid fa-clock-rotate-left text-base"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-white">Aktivitas Terakhir</h3>
                    <p class="text-[10px] text-white/40 mt-0.5">3 catatan perjalanan terbaru</p>
                </div>
            </div>
            <a href="{{ route('perjalanan.riwayat') }}" class="text-[10px] font-bold text-cyan-300 hover:text-cyan-200 transition-colors uppercase tracking-widest flex items-center space-x-1">
                <span>Lihat Semua</span>
                <i class="fa-solid fa-arrow-right text-[8px]"></i>
            </a>
        </div>

        <div class="space-y-3">
            @foreach($recentLogs as $log)
            <div class="flex items-center space-x-4 p-3.5 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-white/15 transition-all duration-300">
                <!-- Temp Badge -->
                <div class="shrink-0">
                    @if($log->suhu_tubuh < 37.5)
                        <div class="w-11 h-11 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center">
                            <span class="text-sm font-black text-emerald-300">{{ number_format($log->suhu_tubuh, 1) }}</span>
                        </div>
                    @else
                        <div class="w-11 h-11 rounded-xl bg-rose-500/20 border border-rose-500/30 flex items-center justify-center animate-pulse">
                            <span class="text-sm font-black text-rose-300">{{ number_format($log->suhu_tubuh, 1) }}</span>
                        </div>
                    @endif
                </div>
                
                <!-- Info -->
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-cyan-300 truncate">{{ $log->lokasi }}</p>
                    <p class="text-[10px] text-white/40 mt-0.5">
                        <i class="fa-regular fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M Y') }}
                        <span class="mx-1.5 text-white/20">•</span>
                        <i class="fa-regular fa-clock mr-1"></i>{{ substr($log->jam, 0, 5) }}
                    </p>
                </div>

                <!-- Arrow -->
                <a href="{{ route('perjalanan.riwayat') }}" class="shrink-0 w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 flex items-center justify-center text-white/40 hover:text-cyan-300 transition-all">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- PUSAT EDUKASI & INFO KESEHATAN -->
    <div class="space-y-5">
        <div class="flex items-center space-x-3 px-1">
            <div class="w-8 h-8 rounded-lg bg-violet-500/20 text-violet-300 flex items-center justify-center border border-violet-500/30">
                <i class="fa-solid fa-graduation-cap text-sm"></i>
            </div>
            <div>
                <h3 class="font-bold text-sm text-white">Pusat Edukasi & Info Kesehatan</h3>
                <p class="text-[10px] text-white/40">Informasi penting seputar protokol kesehatan</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <!-- Card A: Tips Suhu Tubuh -->
            <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-5 relative overflow-hidden transition-all duration-300 hover:border-white/30 hover:-translate-y-0.5 group">
                <div class="absolute -bottom-8 -right-8 w-20 h-20 bg-emerald-500/10 rounded-full blur-xl group-hover:bg-emerald-500/20 transition-all"></div>
                
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center border border-emerald-500/30 shadow-[0_0_10px_rgba(16,185,129,0.3)]">
                        <i class="fa-solid fa-shield-virus text-sm"></i>
                    </div>
                    <h4 class="font-bold text-xs text-white">Tips Suhu Tubuh Ideal</h4>
                </div>
                
                <p class="text-[11px] text-white/60 leading-relaxed body-font">
                    Minum air secukupnya sebelum check-in, hindari aktivitas fisik berlebih tepat sebelum pengukuran, dan pastikan sirkulasi udara baik.
                </p>
            </div>
            
            <!-- Card B: Kepatuhan Log -->
            <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-5 relative overflow-hidden transition-all duration-300 hover:border-white/30 hover:-translate-y-0.5 group">
                <div class="absolute -bottom-8 -right-8 w-20 h-20 bg-cyan-500/10 rounded-full blur-xl group-hover:bg-cyan-500/20 transition-all"></div>
                
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-cyan-500/20 text-cyan-400 flex items-center justify-center border border-cyan-500/30 shadow-[0_0_10px_rgba(6,182,212,0.3)]">
                            <i class="fa-solid fa-chart-simple text-sm"></i>
                        </div>
                        <h4 class="font-bold text-xs text-white">Kepatuhan Log Pekan Ini</h4>
                    </div>
                    <span class="text-[10px] font-bold text-cyan-300 bg-cyan-500/15 px-1.5 py-0.5 rounded">
                        {{ $totalLogs > 0 ? 'Aktif' : 'Kosong' }}
                    </span>
                </div>
                
                <div class="mt-4 space-y-1.5">
                    <div class="flex items-center justify-between text-[10px] text-white/50">
                        <span>Konsistensi Catatan</span>
                        <span class="font-semibold text-white">{{ min($totalLogs * 20, 100) }}%</span>
                    </div>
                    <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-cyan-400 to-emerald-400 rounded-full transition-all duration-500" 
                             style="width: {{ min($totalLogs * 20, 100) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Card C: Protokol Kesehatan -->
            <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-5 relative overflow-hidden transition-all duration-300 hover:border-white/30 hover:-translate-y-0.5 group">
                <div class="absolute -bottom-8 -right-8 w-20 h-20 bg-amber-500/10 rounded-full blur-xl group-hover:bg-amber-500/20 transition-all"></div>
                
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center border border-amber-500/30 shadow-[0_0_10px_rgba(245,158,11,0.3)]">
                        <i class="fa-solid fa-book-medical text-sm"></i>
                    </div>
                    <h4 class="font-bold text-xs text-white">Panduan Protokol</h4>
                </div>
                
                <p class="text-[11px] text-white/60 leading-relaxed body-font">
                    Selalu gunakan masker di tempat ramai, cuci tangan sebelum makan, dan catat setiap kunjungan untuk membantu proses tracing.
                </p>
            </div>
            
        </div>
    </div>

</div>
@endsection
