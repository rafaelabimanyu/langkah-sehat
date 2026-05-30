@extends('layouts.app')

@section('title', __('Admin Monitoring'))
@section('page_header', __('Monitoring Global'))

@section('content')
<div class="space-y-6">

    <!-- Critical Alert Banner -->
    @if(isset($highTempCount) && $highTempCount > 0)
    <div class="bg-rose-100/90 backdrop-blur-md border border-rose-200 rounded-3xl p-4 shadow-lg shadow-rose-500/10 flex items-start space-x-4 animate-pulse relative overflow-hidden transition-all duration-300">
        <div class="absolute -right-4 -top-4 w-20 h-20 bg-rose-500/10 rounded-full blur-xl"></div>
        <div class="w-10 h-10 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center shrink-0 text-rose-500 relative z-10">
            <i class="fa-solid fa-triangle-exclamation text-lg"></i>
        </div>
        <div class="flex-1 relative z-10">
            <h3 class="font-bold text-rose-800 text-sm">{{ __('Peringatan: Terdeteksi pengguna dengan kondisi demam tinggi!') }}</h3>
            <p class="text-xs text-rose-600 mt-1 font-medium">{{ __('Terdapat :count log perjalanan terbaru dengan suhu tubuh >= 37.5°C. Harap tingkatkan pengawasan.', ['count' => $highTempCount]) }}</p>
        </div>
    </div>
    @endif
    
    <!-- Analytics Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Card 1: Total Registered Users -->
        <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-lg rounded-3xl p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-1">
            <div class="absolute -top-6 -right-6 w-20 h-20 bg-[#5c8d9d]/10 rounded-full blur-xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest">{{ __('Total Pengguna') }}</p>
                    <h3 class="text-3xl font-extrabold mt-2 tracking-tight text-[#1a365d]">{{ $totalUsers }}</h3>
                    <p class="text-xs text-slate-400 mt-1">{{ __('Masyarakat & Admin aktif') }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Card 2: Total Travel Logs -->
        <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-lg rounded-3xl p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-1">
            <div class="absolute -top-6 -right-6 w-20 h-20 bg-[#7da8b6]/10 rounded-full blur-xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest">{{ __('Total Log') }}</p>
                    <h3 class="text-3xl font-extrabold mt-2 tracking-tight text-[#1a365d]">{{ $totalLogs }}</h3>
                    <p class="text-xs text-slate-400 mt-1">{{ __('Semua riwayat terdata') }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#5c8d9d]/10 text-[#4a7a8a] flex items-center justify-center border border-[#5c8d9d]/20">
                    <i class="fa-solid fa-route text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Card 3: High Temperature Alert Count -->
        <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-lg rounded-3xl p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-1">
            <div class="absolute -top-6 -right-6 w-20 h-20 bg-rose-100 rounded-full blur-xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest">{{ __('Suhu Tinggi') }}</p>
                    <h3 class="text-3xl font-extrabold mt-2 tracking-tight text-rose-600 flex items-center">
                        {{ $highTempCount }}
                        @if($highTempCount > 0)
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500 ml-2 animate-ping inline-block"></span>
                        @endif
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">{{ __('Suhu &ge; 37.5°C terdeteksi') }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-100 {{ $highTempCount > 0 ? 'shadow-lg shadow-rose-200' : '' }}">
                    <i class="fa-solid fa-temperature-arrow-up text-xl"></i>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Filters & Search Panel -->
    <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-sm rounded-3xl p-6 transition-all duration-300">
        <form action="{{ route('admin.dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            <!-- Search user name, email, location -->
            <div class="relative">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('Cari Data') }}</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}"
                        class="w-full bg-white border border-slate-200 rounded-2xl pl-9 pr-4 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all shadow-sm text-xs font-semibold"
                        placeholder="{{ __('Cari lokasi, nama, atau email...') }}">
                </div>
            </div>
            
            <!-- Date Filter -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('Filter Tanggal') }}</label>
                <input type="date" name="filter_tanggal" value="{{ $filterTanggal }}"
                    class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all shadow-sm text-xs font-semibold">
            </div>
            
            <!-- Temperature Filter -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('Kondisi Suhu') }}</label>
                <select name="filter_suhu"
                    class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all shadow-sm text-xs font-semibold">
                    <option value="">{{ __('Semua Suhu') }}</option>
                    <option value="normal" {{ $filterSuhu === 'normal' ? 'selected' : '' }}>{{ __('Suhu Normal (< 37.5°C)') }}</option>
                    <option value="demam" {{ $filterSuhu === 'demam' ? 'selected' : '' }}>{{ __('Suhu Demam (>= 37.5°C)') }}</option>
                </select>
            </div>
            
            <!-- Action buttons -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 bg-[#4a7a8a] hover:bg-[#3b6370] text-white font-semibold py-2.5 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 cursor-pointer flex items-center justify-center space-x-2 shadow-sm text-xs font-bold">
                    <i class="fa-solid fa-filter text-[10px]"></i>
                    <span>{{ __('Terapkan') }}</span>
                </button>
                
                @if($search || $filterTanggal || $filterSuhu)
                    <a href="{{ route('admin.dashboard') }}" class="px-4 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-600 py-2.5 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 flex items-center justify-center shadow-sm" title="{{ __('Reset Filter') }}">
                        <i class="fa-solid fa-rotate-right text-[10px]"></i>
                    </a>
                @endif
            </div>
            
        </form>
    </div>

    <!-- Global Logs Table Container -->
    <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-xl rounded-3xl overflow-hidden transition-all duration-300" x-data="{ openDeleteModal: false, deleteUrl: '' }">
        
        <!-- Header title of monitoring table -->
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
            <h3 class="font-bold text-base flex items-center space-x-2 text-[#1a365d]">
                <i class="fa-solid fa-display text-[#4a7a8a]"></i>
                <span>{{ __('Laporan Perjalanan Global') }}</span>
            </h3>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.print', ['search' => $search, 'filter_tanggal' => $filterTanggal, 'filter_suhu' => $filterSuhu]) }}" 
                   target="_blank" 
                   class="px-4 py-2 bg-[#4a7a8a] hover:bg-[#3b6370] text-white font-bold text-xs rounded-full shadow-md transition-all duration-300 flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-print"></i>
                    <span>{{ __('Cetak Laporan') }}</span>
                </a>
                <span class="text-xs text-slate-500">{{ __('Ditemukan: :count data log', ['count' => $perjalanans->count()]) }}</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Nama') }}</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Tanggal') }}</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Lokasi') }}</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Suhu Tubuh') }}</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Catatan') }}</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($perjalanans as $index => $log)
                        <tr class="hover:bg-slate-50 transition-all duration-200">
                            <!-- No -->
                            <td class="px-6 py-4 text-sm text-slate-500 font-medium">{{ $index + 1 }}</td>
                            
                            <!-- User info columns -->
                            <td class="px-6 py-4 text-sm">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-slate-800">{{ $log->user->name ?? 'Guest' }}</span>
                                    <span class="text-xs text-slate-500 mt-0.5"><i class="fa-regular fa-envelope text-[10px] mr-1"></i>{{ $log->user->email ?? 'N/A' }}</span>
                                </div>
                            </td>
                            
                            <!-- Date time -->
                            <td class="px-6 py-4 text-sm font-semibold">
                                <div class="flex flex-col">
                                    <span class="text-slate-800">{{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M Y') }}</span>
                                    <span class="text-xs text-slate-500 mt-0.5"><i class="fa-regular fa-clock text-[10px] mr-1"></i>{{ substr($log->jam, 0, 5) }} WIB</span>
                                </div>
                            </td>
                            
                            <!-- Location -->
                            <td class="px-6 py-4 text-sm font-semibold text-[#1a365d]">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-location-dot text-slate-400"></i>
                                    <span>{{ $log->lokasi }}</span>
                                </div>
                            </td>
                            
                            <!-- Temperature -->
                            <td class="px-6 py-4 text-sm">
                                @if($log->suhu_tubuh < 37.5)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold text-emerald-700 bg-emerald-100 border border-emerald-200">
                                        <i class="fa-solid fa-temperature-low mr-1.5 text-xs"></i>{{ number_format($log->suhu_tubuh, 1) }}°C
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold text-rose-700 bg-rose-100 border border-rose-200 shadow-sm animate-pulse">
                                        <i class="fa-solid fa-temperature-high mr-1.5 text-xs"></i>{{ number_format($log->suhu_tubuh, 1) }}°C
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Note -->
                            <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate" title="{{ $log->catatan }}">
                                {{ $log->catatan ?: '-' }}
                            </td>
                            
                            <!-- Delete action (For Anomalous Logs) -->
                            <td class="px-6 py-4 text-sm text-center">
                                <button type="button" 
                                        @click="deleteUrl = '{{ route('admin.perjalanan.destroy', $log->id) }}'; openDeleteModal = true"
                                        class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-600 rounded-lg hover:-translate-y-0.5 transition-all duration-300 cursor-pointer text-xs font-bold" 
                                        title="{{ __('Hapus') }}">
                                    <i class="fa-regular fa-trash-can mr-1"></i>{{ __('Hapus') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 text-2xl border border-slate-100">
                                        <i class="fa-solid fa-display-slash"></i>
                                    </div>
                                    <p class="font-medium text-base text-slate-600">{{ __('Belum ada catatan.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Elegant Delete Confirmation Modal using Alpine.js -->
        <div x-show="openDeleteModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
             style="display: none;">
             
             <!-- Modal Panel -->
             <div class="w-full max-w-md bg-white border border-slate-200 rounded-3xl p-6 shadow-2xl transform transition-all duration-300"
                  @click.away="openDeleteModal = false">
                  
                  <div class="flex items-start space-x-4">
                      <div class="w-10 h-10 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-500 shrink-0">
                          <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                      </div>
                      <div class="flex-1 mt-1">
                          <h3 class="text-lg font-bold text-slate-800">{{ __('Konfirmasi Hapus Admin') }}</h3>
                          <p class="text-sm text-slate-500 mt-1 body-font font-medium">{{ __('Apakah Anda yakin ingin menghapus data ini?') }}</p>
                      </div>
                  </div>
                  
                  <div class="mt-6 flex justify-end space-x-3 body-font">
                      <button type="button" 
                              @click="openDeleteModal = false" 
                              class="px-4 py-2 rounded-full bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold transition-all duration-300 cursor-pointer text-xs">
                          {{ __('Batal') }}
                      </button>
                      <form :action="deleteUrl" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" 
                                  class="px-4 py-2 rounded-full bg-rose-500 hover:bg-rose-600 text-white font-bold transition-all duration-300 hover:shadow-lg cursor-pointer text-xs">
                              {{ __('Hapus') }}
                          </button>
                      </form>
                  </div>
             </div>
        </div>

    </div>
</div>
@endsection
