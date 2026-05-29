@extends('layouts.app')

@section('title', 'Admin Monitoring')
@section('page_header', 'Panel Pengawasan Global')

@section('content')
<div class="space-y-6">
    
    <!-- Analytics Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Card 1: Total Registered Users -->
        <div class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-1">
            <div class="absolute -top-6 -right-6 w-20 h-20 bg-blue-500/10 rounded-full blur-xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-white/50 uppercase tracking-widest">Total Pengguna Terdaftar</p>
                    <h3 class="text-3xl font-extrabold mt-2 tracking-tight">{{ $totalUsers }}</h3>
                    <p class="text-xs text-white/40 mt-1">Masyarakat & Admin aktif</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-500/20 text-blue-300 flex items-center justify-center border border-blue-500/20">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Card 2: Total Travel Logs -->
        <div class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-1">
            <div class="absolute -top-6 -right-6 w-20 h-20 bg-cyan-500/10 rounded-full blur-xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-white/50 uppercase tracking-widest">Total Log Perjalanan</p>
                    <h3 class="text-3xl font-extrabold mt-2 tracking-tight">{{ $totalLogs }}</h3>
                    <p class="text-xs text-white/40 mt-1">Semua riwayat terdata</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-cyan-500/20 text-cyan-300 flex items-center justify-center border border-cyan-500/20">
                    <i class="fa-solid fa-route text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Card 3: High Temperature Alert Count -->
        <div class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-1">
            <div class="absolute -top-6 -right-6 w-20 h-20 bg-rose-500/10 rounded-full blur-xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-white/50 uppercase tracking-widest">Suhu Tubuh Tinggi (Alert)</p>
                    <h3 class="text-3xl font-extrabold mt-2 tracking-tight text-rose-300 flex items-center">
                        {{ $highTempCount }}
                        @if($highTempCount > 0)
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-400 ml-2 animate-ping inline-block"></span>
                        @endif
                    </h3>
                    <p class="text-xs text-white/40 mt-1">Suhu &ge; 37.5°C terdeteksi</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-500/20 text-rose-300 flex items-center justify-center border border-rose-500/20 {{ $highTempCount > 0 ? 'shadow-lg shadow-rose-500/30' : '' }}">
                    <i class="fa-solid fa-temperature-arrow-up text-xl"></i>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Filters & Search Panel -->
    <div class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl p-6 transition-all duration-300">
        <form action="{{ route('admin.dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            <!-- Search user name, email, location -->
            <div class="relative">
                <label class="block text-xs font-semibold text-white/60 uppercase tracking-wider mb-2">Cari Data</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/40">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}"
                        class="w-full bg-white/5 border border-white/10 rounded-xl pl-9 pr-4 py-2 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/10"
                        placeholder="Nama, email, lokasi...">
                </div>
            </div>
            
            <!-- Date Filter -->
            <div>
                <label class="block text-xs font-semibold text-white/60 uppercase tracking-wider mb-2">Filter Tanggal</label>
                <input type="date" name="filter_tanggal" value="{{ $filterTanggal }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/10">
            </div>
            
            <!-- Temperature Filter -->
            <div>
                <label class="block text-xs font-semibold text-white/60 uppercase tracking-wider mb-2">Kondisi Suhu</label>
                <select name="filter_suhu"
                    class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all">
                    <option value="">Semua Data</option>
                    <option value="normal" {{ $filterSuhu === 'normal' ? 'selected' : '' }}>Normal (< 37.5°C)</option>
                    <option value="demam" {{ $filterSuhu === 'demam' ? 'selected' : '' }}>Demam / Alert (≥ 37.5°C)</option>
                </select>
            </div>
            
            <!-- Action buttons -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 bg-white/15 hover:bg-white/25 border border-white/20 text-white font-semibold py-2 rounded-xl transition-all duration-300 hover:-translate-y-0.5 cursor-pointer flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-filter"></i>
                    <span>Terapkan</span>
                </button>
                
                @if($search || $filterTanggal || $filterSuhu)
                    <a href="{{ route('admin.dashboard') }}" class="px-4 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-300 py-2 rounded-xl transition-all duration-300 hover:-translate-y-0.5 flex items-center justify-center" title="Reset Pencarian">
                        <i class="fa-solid fa-rotate-right"></i>
                    </a>
                @endif
            </div>
            
        </form>
    </div>

    <!-- Global Logs Table Container -->
    <div class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl overflow-hidden transition-all duration-300" x-data="{ openDeleteModal: false, deleteUrl: '' }">
        
        <!-- Header title of monitoring table -->
        <div class="px-6 py-4 bg-white/5 border-b border-white/10 flex items-center justify-between">
            <h3 class="font-bold text-base flex items-center space-x-2 text-cyan-300">
                <i class="fa-solid fa-display"></i>
                <span>Tabel Pemantauan Perjalanan Nasional</span>
            </h3>
            <span class="text-xs text-white/50">Ditemukan: <strong class="text-white">{{ $perjalanans->count() }}</strong> data log</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 border-b border-white/10">
                        <th class="px-6 py-4 text-xs font-semibold text-white/70 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/70 uppercase tracking-wider">Nama & Email</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/70 uppercase tracking-wider">Tanggal & Waktu</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/70 uppercase tracking-wider">Lokasi Kunjungan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/70 uppercase tracking-wider">Suhu Tubuh</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/70 uppercase tracking-wider">Catatan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/70 uppercase tracking-wider text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($perjalanans as $index => $log)
                        <tr class="hover:bg-white/5 transition-all duration-200">
                            <!-- No -->
                            <td class="px-6 py-4 text-sm text-white/60 font-medium">{{ $index + 1 }}</td>
                            
                            <!-- User info columns -->
                            <td class="px-6 py-4 text-sm">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-white">{{ $log->user->name ?? 'Guest' }}</span>
                                    <span class="text-xs text-white/40 mt-0.5"><i class="fa-regular fa-envelope text-[10px] mr-1"></i>{{ $log->user->email ?? 'N/A' }}</span>
                                </div>
                            </td>
                            
                            <!-- Date time -->
                            <td class="px-6 py-4 text-sm font-semibold">
                                <div class="flex flex-col">
                                    <span>{{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M Y') }}</span>
                                    <span class="text-xs text-white/50 mt-0.5"><i class="fa-regular fa-clock text-[10px] mr-1"></i>{{ substr($log->jam, 0, 5) }} WIB</span>
                                </div>
                            </td>
                            
                            <!-- Location -->
                            <td class="px-6 py-4 text-sm font-semibold text-cyan-300">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-location-dot text-white/40"></i>
                                    <span>{{ $log->lokasi }}</span>
                                </div>
                            </td>
                            
                            <!-- Temperature -->
                            <td class="px-6 py-4 text-sm">
                                @if($log->suhu_tubuh < 37.5)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold text-emerald-300 bg-emerald-500/20 border border-emerald-500/10">
                                        <i class="fa-solid fa-temperature-low mr-1.5 text-xs"></i>{{ number_format($log->suhu_tubuh, 1) }}°C
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold text-rose-300 bg-rose-500/20 border border-rose-500/10 shadow-sm shadow-rose-500/50 animate-pulse">
                                        <i class="fa-solid fa-temperature-high mr-1.5 text-xs"></i>{{ number_format($log->suhu_tubuh, 1) }}°C
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Note -->
                            <td class="px-6 py-4 text-sm text-white/70 max-w-xs truncate" title="{{ $log->catatan }}">
                                {{ $log->catatan ?: '-' }}
                            </td>
                            
                            <!-- Delete action (For Anomalous Logs) -->
                            <td class="px-6 py-4 text-sm text-center">
                                <button type="button" 
                                        @click="deleteUrl = '{{ route('admin.perjalanan.destroy', $log->id) }}'; openDeleteModal = true"
                                        class="px-3 py-1.5 bg-rose-500/15 hover:bg-rose-500/25 border border-rose-500/20 text-rose-300 rounded-lg hover:-translate-y-0.5 transition-all duration-300 cursor-pointer text-xs font-bold" 
                                        title="Hapus Data Anomalus">
                                    <i class="fa-regular fa-trash-can mr-1"></i>Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-white/50">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-white/30 text-2xl border border-white/10">
                                        <i class="fa-solid fa-display-slash"></i>
                                    </div>
                                    <p class="font-medium text-base text-white/70">Tidak ada log perjalanan global</p>
                                    <p class="text-xs text-white/40">Database bersih dari catatan perjalanan masyarakat.</p>
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
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm"
             style="display: none;">
             
             <!-- Modal Panel -->
             <div class="w-full max-w-md bg-slate-950 border border-white/20 rounded-2xl p-6 shadow-2xl transform transition-all duration-300"
                  @click.away="openDeleteModal = false">
                  
                  <div class="flex items-start space-x-4">
                      <div class="w-10 h-10 rounded-full bg-rose-500/20 border border-rose-500/30 flex items-center justify-center text-rose-400 shrink-0">
                          <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                      </div>
                      <div class="flex-1">
                          <h3 class="text-lg font-bold text-white">Konfirmasi Hapus Admin</h3>
                          <p class="text-sm text-white/60 mt-1 body-font font-medium">Apakah Anda yakin ingin menghapus data log anomalus ini sebagai Admin? Tindakan ini akan menghapus log perjalanan dari pengguna tersebut secara permanen.</p>
                      </div>
                  </div>
                  
                  <div class="mt-6 flex justify-end space-x-3 body-font">
                      <button type="button" 
                              @click="openDeleteModal = false" 
                              class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-white font-semibold transition-all duration-300 cursor-pointer">
                          Batal
                      </button>
                      <form :action="deleteUrl" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" 
                                  class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold transition-all duration-300 hover:shadow-lg hover:shadow-rose-600/30 cursor-pointer">
                              Hapus Permanen
                          </button>
                      </form>
                  </div>
             </div>
        </div>

    </div>
</div>
@endsection
