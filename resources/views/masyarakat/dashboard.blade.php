@extends('layouts.app')

@section('title', __('Dashboard Masyarakat'))

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    
    <!-- Greeting Card -->
    <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-xl rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300">
        <!-- Soft decorative glow -->
        <div class="absolute -top-12 -left-12 w-40 h-40 bg-[#7da8b6]/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-[#5c8d9d]/10 rounded-full blur-3xl -z-10"></div>
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between relative z-10 gap-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('profile.edit') }}" class="group/avatar relative block w-16 h-16 rounded-full shrink-0 shadow-md border border-slate-100 bg-white overflow-hidden transition-all duration-300 hover:shadow-lg hover:scale-105">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover transition-all duration-500 group-hover/avatar:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-[#4a7a8a] text-2xl font-black tracking-tight select-none transition-all duration-500 group-hover/avatar:scale-110">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-[#1a365d]/40 opacity-0 group-hover/avatar:opacity-100 flex flex-col items-center justify-center text-white transition-opacity duration-300 ease-out backdrop-blur-[2px]">
                        <i class="fa-solid fa-user-pen text-xs mb-0.5 transform translate-y-2 group-hover/avatar:translate-y-0 transition-transform duration-300 ease-out"></i>
                        <span class="text-[8px] font-black uppercase tracking-widest scale-90 transform translate-y-2 group-hover/avatar:translate-y-0 transition-transform duration-300 ease-out">
                            {{ __('Edit') }}
                        </span>
                    </div>
                </a>
                <div>
                    <h2 class="text-2xl font-extrabold tracking-tight text-[#1a365d]">{{ __('Halo, :name!', ['name' => Auth::user()->name]) }}</h2>
                    <p class="text-sm text-slate-500 mt-1 flex items-center">
                        <i class="fa-regular fa-calendar-check mr-2 text-[#4a7a8a]"></i>
                        {{ __('Hari ini:') }} <strong class="ml-1 text-slate-700">{{ now()->translatedFormat('l, d F Y') }}</strong>
                    </p>
                </div>
            </div>

            <!-- Health Status Badge based on latest log -->
            @php
                $latestLog = Auth::user()->perjalanans()->latest('tanggal')->first();
            @endphp
            <div class="bg-white border border-slate-200 rounded-3xl p-4 flex items-center space-x-4 shadow-sm min-w-[200px]">
                @if(!$latestLog)
                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-question text-lg drop-shadow-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ __('Status Terakhir') }}</p>
                        <p class="font-semibold text-slate-700 text-sm">{{ __('Belum Ada Data') }}</p>
                    </div>
                @elseif($latestLog->suhu_tubuh >= 37.5)
                    <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-500 flex items-center justify-center shrink-0 relative">
                        <span class="absolute inset-0 rounded-full bg-rose-400 opacity-30 animate-ping"></span>
                        <i class="fa-solid fa-triangle-exclamation text-lg relative z-10 drop-shadow-md shadow-rose-500/20"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ __('Status Terakhir') }}</p>
                        <p class="font-bold text-rose-600 text-sm">{{ __('Demam') }} ({{ $latestLog->suhu_tubuh }}°C)</p>
                    </div>
                @else
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-check-circle text-lg drop-shadow-md shadow-emerald-500/20"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ __('Status Terakhir') }}</p>
                        <p class="font-bold text-emerald-700 text-sm">{{ __('Normal') }} ({{ $latestLog->suhu_tubuh }}°C)</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Stats & Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Total Logs Card -->
        <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-lg rounded-3xl p-6 flex flex-col justify-between hover:-translate-y-1 transition-transform">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-full bg-[#5c8d9d]/10 text-[#4a7a8a] flex items-center justify-center border border-[#5c8d9d]/20">
                    <i class="fa-solid fa-route text-xl"></i>
                </div>
                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-bold tracking-wider uppercase">{{ __('Riwayat') }}</span>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold mb-1">{{ __('Total Perjalanan') }}</p>
                <h3 class="text-3xl font-black text-[#1a365d] tracking-tight">{{ Auth::user()->perjalanans()->count() }} <span class="text-sm font-medium text-slate-400">{{ __('log') }}</span></h3>
            </div>
        </div>

        <!-- Average Temp / Status Imun Card -->
        @php
            $avgTemp = Auth::user()->perjalanans()->avg('suhu_tubuh');
        @endphp
        <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-lg rounded-3xl p-6 flex flex-col justify-between hover:-translate-y-1 transition-transform relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shadow-inner">
                    <i class="fa-solid fa-temperature-half text-xl drop-shadow-md shadow-emerald-500/20"></i>
                </div>
                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-bold tracking-wider uppercase">{{ __('Status Imun') }}</span>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold mb-1">{{ __('Kesiapan Perjalanan') }}</p>
                @if($avgTemp == null)
                    <h3 class="text-xl font-bold text-slate-400 mt-2">{{ __('Belum ada data') }}</h3>
                @elseif($avgTemp < 37.5)
                    <div class="bg-emerald-100/50 border border-emerald-200 rounded-xl px-3 py-2 inline-block mt-1 shadow-sm">
                        <span class="text-sm font-bold text-emerald-700"><i class="fa-solid fa-shield-virus mr-1"></i> {{ __('Tubuh Prima & Siap Bepergian') }}</span>
                    </div>
                @else
                    <div class="bg-rose-100/50 border border-rose-200 rounded-xl px-3 py-2 inline-block mt-1 shadow-sm animate-pulse">
                        <span class="text-sm font-bold text-rose-700"><i class="fa-solid fa-virus-covid mr-1"></i> {{ __('Kondisi Rentan, Istirahatlah') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Card -->
        <div class="bg-gradient-to-br from-[#4a7a8a] to-[#3b6370] rounded-3xl p-6 flex flex-col justify-center relative overflow-hidden shadow-lg shadow-[#4a7a8a]/20 group hover:-translate-y-1 transition-transform">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-10 translate-x-10 blur-xl"></div>
            
            <h3 class="text-white font-bold text-lg mb-2 relative z-10">{{ __('Mulai Perjalanan Baru?') }}</h3>
            <p class="text-white/70 text-xs mb-5 relative z-10">{{ __('Catat lokasi dan suhu tubuh Anda saat ini untuk riwayat medis.') }}</p>
            
            <a href="{{ route('perjalanan.create') }}" class="w-full bg-white text-[#1a365d] text-sm font-bold py-3 rounded-full text-center hover:bg-slate-50 transition-colors shadow-md relative z-10">
                <i class="fa-solid fa-plus mr-2"></i>{{ __('Catat Sekarang') }}
            </a>
        </div>
    </div>

    <!-- Chart & Recent Activity Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Weekly Chart -->
        <div class="lg:col-span-2 bg-white/80 backdrop-blur-lg border border-slate-200 shadow-xl rounded-3xl p-6 relative">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-lg text-[#1a365d] flex items-center">
                        <i class="fa-solid fa-chart-simple mr-2 text-[#4a7a8a]"></i>{{ __('Grafik Suhu 7 Hari Terakhir') }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">{{ __('Pantauan tren suhu tubuh harian Anda.') }}</p>
                </div>
            </div>
            
            @php
                $chartData = collect(range(0, 6))->map(function($days) {
                    $date = now()->subDays(6 - $days)->format('Y-m-d');
                    $logs = Auth::user()->perjalanans()->whereDate('tanggal', $date)->get();
                    $avg = $logs->count() > 0 ? $logs->avg('suhu_tubuh') : 0;
                    return [
                        'date' => now()->subDays(6 - $days)->translatedFormat('d M'),
                        'avg' => $avg,
                        'count' => $logs->count()
                    ];
                });
                
                $totalLogsLast7Days = $chartData->sum('count');
                $maxTemp = 40; 
            @endphp

            <div class="w-full relative">
                <!-- Empty State Glassmorphic Overlay -->
                @if($totalLogsLast7Days == 0)
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/40 backdrop-blur-[2px] border border-white/30 rounded-2xl p-4 z-20 text-center transition-all duration-300">
                        <i class="fa-solid fa-chart-line text-slate-300 text-3xl mb-2"></i>
                        <p class="text-xs text-slate-500 max-w-md leading-relaxed px-4">
                            {{ __('Belum Ada Aktivitas Catatan Suhu untuk Minggu Ini. Mulai catat perjalanan Anda untuk melihat statistik harian.') }}
                        </p>
                    </div>
                @endif

                <!-- Bars Grid -->
                <div class="grid grid-cols-7 gap-2 items-end h-48 relative pt-4 {{ $totalLogsLast7Days == 0 ? 'opacity-30' : '' }} transition-opacity duration-300">
                    <!-- Target lines -->
                    <div class="absolute inset-x-0 bottom-0 top-0 flex flex-col justify-between z-0">
                        <div class="w-full h-px bg-slate-200/50 flex items-center"><span class="text-[9px] text-rose-400 font-bold -mt-4 ml-1">{{ __('Alert (37.5°C)') }}</span></div>
                        <div class="w-full h-px bg-slate-100"></div>
                        <div class="w-full h-px bg-slate-100"></div>
                        <div class="w-full h-px bg-slate-100"></div>
                    </div>

                    @foreach($chartData as $data)
                        @php
                            $height = $data['avg'] > 0 ? ($data['avg'] / $maxTemp) * 100 : 0;
                            $isHigh = $data['avg'] >= 37.5;
                            $colorClass = $data['avg'] == 0 ? 'bg-transparent' : ($isHigh ? 'bg-rose-400 shadow-rose-400/50' : 'bg-[#7da8b6] shadow-[#7da8b6]/30');
                        @endphp
                        <div class="flex flex-col items-center w-full h-full justify-end z-10 group relative">
                            <!-- Tooltip -->
                            @if($data['avg'] > 0)
                                <div class="absolute -top-8 bg-slate-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-20">
                                    {{ number_format($data['avg'], 1) }}°C
                                </div>
                            @endif
                            
                            <!-- Bar -->
                            <div class="w-full max-w-[40px] rounded-t-lg {{ $colorClass }} shadow-lg transition-all duration-500 group-hover:brightness-110 relative overflow-hidden" 
                                 style="height: {{ $height }}%">
                                 @if($isHigh)
                                    <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                                 @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Date Labels Grid -->
                <div class="grid grid-cols-7 gap-2 text-center text-xs mt-2 text-slate-500 font-semibold {{ $totalLogsLast7Days == 0 ? 'opacity-30' : '' }} transition-opacity duration-300">
                    @foreach($chartData as $data)
                        <span class="truncate w-full">{{ $data['date'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Activity Feed & Doctor Notes -->
        <div class="flex flex-col space-y-6">
            
            <!-- Doctor Consultation Notes Widget -->
            @php
                $latestConsultation = Auth::user()->perjalanans()->whereNotNull('catatan')->where('catatan', '!=', '')->latest('tanggal')->first();
            @endphp
            <div class="bg-slate-900 border border-slate-700 shadow-xl rounded-3xl p-5 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-[#5c8d9d]/30 rounded-full blur-2xl"></div>
                <div class="flex items-center space-x-3 mb-3 relative z-10">
                    <div class="w-8 h-8 rounded-full bg-[#5c8d9d]/20 text-[#7da8b6] flex items-center justify-center border border-[#5c8d9d]/30">
                        <i class="fa-solid fa-user-doctor text-sm drop-shadow-md"></i>
                    </div>
                    <h3 class="font-bold text-white text-sm">{{ __('Catatan Medis Terakhir') }}</h3>
                </div>
                <div class="relative z-10 bg-slate-800/80 rounded-2xl p-4 border border-slate-700/50">
                    @if($latestConsultation)
                        <p class="text-xs text-[#7da8b6] font-medium mb-1"><i class="fa-regular fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($latestConsultation->tanggal)->translatedFormat('d M Y') }}</p>
                        <p class="text-sm text-slate-200 italic leading-relaxed">"{{ $latestConsultation->catatan }}"</p>
                    @else
                        <p class="text-sm text-slate-400 italic">{{ __('Belum ada catatan konsultasi medis yang tersimpan.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Recent Log Feed -->
            <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-xl rounded-3xl p-6 flex flex-col flex-1">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-bold text-[#1a365d] flex items-center">
                            <i class="fa-solid fa-clock-rotate-left mr-2 text-[#4a7a8a] drop-shadow-sm"></i>{{ __('Log Terakhir') }}
                        </h3>
                    </div>
                    <a href="{{ route('perjalanan.riwayat') }}" class="text-[10px] font-bold text-[#4a7a8a] hover:text-[#1a365d] transition-colors">{{ __('Lihat Semua') }}</a>
                </div>

                <div class="flex-1 overflow-y-auto pr-2 space-y-4">
                    @php
                        $recentLogs = Auth::user()->perjalanans()->orderBy('tanggal', 'desc')->orderBy('jam', 'desc')->limit(3)->get();
                    @endphp

                    @forelse($recentLogs as $log)
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex space-x-3 group hover:border-[#7da8b6]/30 hover:bg-white transition-all">
                            <div class="w-9 h-9 rounded-full bg-[#edf3f6] flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-location-dot text-[#4a7a8a] text-sm drop-shadow-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-semibold text-sm text-[#1e3a5f] truncate" title="{{ $log->lokasi }}">{{ $log->lokasi }}</h4>
                                    <span class="text-[10px] text-slate-400 font-medium whitespace-nowrap ml-2">{{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M') }}</span>
                                </div>
                                <div class="flex items-center justify-between mt-1.5">
                                    <span class="text-[10px] text-slate-500 flex items-center">
                                        <i class="fa-regular fa-clock mr-1 text-slate-400"></i>{{ substr($log->jam, 0, 5) }}
                                    </span>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $log->suhu_tubuh >= 37.5 ? 'bg-rose-100 text-rose-600' : 'bg-emerald-100 text-emerald-600' }}">
                                        {{ $log->suhu_tubuh }}°C
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full text-slate-400 space-y-3 py-10 border-2 border-dashed border-slate-200 rounded-2xl">
                            <i class="fa-solid fa-clipboard-list text-2xl drop-shadow-sm"></i>
                            <p class="text-xs text-center font-medium">{{ __('Belum ada catatan.') }}<br>{{ __('Mulai tracking perdana Anda.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
