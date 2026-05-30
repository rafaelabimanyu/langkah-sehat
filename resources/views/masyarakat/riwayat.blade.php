@extends('layouts.app')

@section('title', 'Riwayat Log & Analisis')

@section('content')
<div class="space-y-6">

    <!-- Page Header with Print Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-500/20 text-indigo-300 flex items-center justify-center border border-indigo-500/30 shadow-[0_0_15px_rgba(99,102,241,0.2)]">
                <i class="fa-solid fa-calendar-days text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl font-extrabold tracking-tight">Riwayat Log & Analisis</h1>
                <p class="text-xs text-white/40 mt-0.5 body-font">Manajemen data dan analisis perjalanan pribadi</p>
            </div>
        </div>
        
        <!-- Print / Export Button -->
        <a href="{{ route('perjalanan.print', ['search' => $search, 'filter_suhu' => $filterSuhu, 'filter_tanggal' => $filterTanggal]) }}" 
           target="_blank"
           class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-violet-500/20 to-indigo-500/20 border border-violet-400/30 hover:border-violet-400/50 text-violet-300 hover:text-white font-semibold text-xs transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_0_20px_rgba(139,92,246,0.2)]">
            <i class="fa-solid fa-print"></i>
            <span>Cetak Riwayat PDF / Print</span>
        </a>
    </div>

    <!-- Quick Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-4 flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-cyan-500/20 text-cyan-300 flex items-center justify-center border border-cyan-500/30">
                <i class="fa-solid fa-route text-base"></i>
            </div>
            <div>
                <p class="text-[10px] text-white/40 uppercase tracking-widest font-semibold">Total Log</p>
                <p class="text-2xl font-black text-white">{{ $totalLogs }}</p>
            </div>
        </div>
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-4 flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center border border-emerald-500/30">
                <i class="fa-solid fa-temperature-half text-base"></i>
            </div>
            <div>
                <p class="text-[10px] text-white/40 uppercase tracking-widest font-semibold">Rata-Rata Suhu</p>
                <p class="text-2xl font-black text-emerald-400">{{ $avgTemp > 0 ? number_format($avgTemp, 1) . '°C' : '—' }}</p>
            </div>
        </div>
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-4 flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-rose-500/20 text-rose-300 flex items-center justify-center border border-rose-500/30">
                <i class="fa-solid fa-triangle-exclamation text-base"></i>
            </div>
            <div>
                <p class="text-[10px] text-white/40 uppercase tracking-widest font-semibold">Log Suhu Tinggi</p>
                <p class="text-2xl font-black text-rose-400">{{ $highTempCount }}</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-5 transition-all duration-300 hover:border-white/30">
        <form action="{{ route('perjalanan.riwayat') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
            <!-- Search -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-semibold text-white/50 uppercase tracking-wider">Cari Lokasi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/30">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}"
                        class="w-full bg-white/5 border border-white/10 rounded-xl pl-9 pr-4 py-2.5 text-xs text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400/30 transition-all duration-300"
                        placeholder="Ketik nama lokasi...">
                </div>
            </div>
            
            <!-- Date Filter -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-semibold text-white/50 uppercase tracking-wider">Tanggal</label>
                <input type="date" name="filter_tanggal" value="{{ $filterTanggal }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400/30 transition-all duration-300">
            </div>
            
            <!-- Temp Filter -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-semibold text-white/50 uppercase tracking-wider">Status Suhu</label>
                <select name="filter_suhu"
                    class="w-full bg-slate-900 border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:ring-2 focus:ring-cyan-400/50 transition-all duration-300">
                    <option value="">Semua</option>
                    <option value="normal" {{ $filterSuhu === 'normal' ? 'selected' : '' }}>Normal (< 37.5°C)</option>
                    <option value="demam" {{ $filterSuhu === 'demam' ? 'selected' : '' }}>Demam (≥ 37.5°C)</option>
                </select>
            </div>
            
            <!-- Filter Buttons -->
            <div class="flex items-center space-x-2">
                <button type="submit" class="flex-1 bg-gradient-to-r from-cyan-500/20 to-emerald-500/20 hover:from-cyan-500/30 hover:to-emerald-500/30 border border-cyan-500/30 text-cyan-300 hover:text-white py-2.5 px-4 rounded-xl transition-all duration-300 hover:-translate-y-0.5 cursor-pointer text-xs font-bold flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filter</span>
                </button>
                
                @if($search || $filterTanggal || $filterSuhu)
                    <a href="{{ route('perjalanan.riwayat') }}" class="bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-300 py-2.5 px-4 rounded-xl transition-all hover:-translate-y-0.5 text-xs flex items-center justify-center space-x-1.5 font-bold" title="Reset Filter">
                        <i class="fa-solid fa-rotate-right"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- History Data Table -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl overflow-hidden transition-all duration-300 hover:border-white/30" x-data="{ openDeleteModal: false, deleteUrl: '' }">
        
        <!-- Table Header -->
        <div class="px-5 py-4 bg-white/5 border-b border-white/10 flex items-center justify-between">
            <h3 class="font-bold text-sm text-cyan-300 flex items-center space-x-2">
                <i class="fa-solid fa-table-list"></i>
                <span>Tabel Riwayat Perjalanan</span>
            </h3>
            <div class="flex items-center space-x-3">
                <span class="text-[10px] text-white/50 font-medium">
                    Tampil: <strong class="text-white/80">{{ $perjalanans->count() }}</strong> entri
                </span>
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 border-b border-white/10">
                        <th class="px-4 py-3.5 text-[10px] font-semibold text-white/70 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3.5 text-[10px] font-semibold text-white/70 uppercase tracking-wider">Waktu Kunjungan</th>
                        <th class="px-4 py-3.5 text-[10px] font-semibold text-white/70 uppercase tracking-wider">Lokasi</th>
                        <th class="px-4 py-3.5 text-[10px] font-semibold text-white/70 uppercase tracking-wider">Suhu</th>
                        <th class="px-4 py-3.5 text-[10px] font-semibold text-white/70 uppercase tracking-wider">Catatan</th>
                        <th class="px-4 py-3.5 text-[10px] font-semibold text-white/70 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($perjalanans as $index => $log)
                        <tr class="hover:bg-white/5 transition-all duration-200 text-xs group">
                            <td class="px-4 py-3.5 text-white/50 font-medium">{{ $index + 1 }}</td>
                            <td class="px-4 py-3.5 font-semibold">
                                <div class="flex flex-col">
                                    <span class="text-white">{{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M Y') }}</span>
                                    <span class="text-[10px] text-white/40 mt-0.5">
                                        <i class="fa-regular fa-clock mr-1"></i>{{ substr($log->jam, 0, 5) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 font-semibold text-cyan-300 max-w-[180px]">
                                <span class="truncate block" title="{{ $log->lokasi }}">{{ $log->lokasi }}</span>
                            </td>
                            <td class="px-4 py-3.5">
                                @if($log->suhu_tubuh < 37.5)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold text-emerald-300 bg-emerald-500/20 border border-emerald-500/20">
                                        <i class="fa-solid fa-check-circle mr-1 text-[8px]"></i>{{ number_format($log->suhu_tubuh, 1) }}°C
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold text-rose-300 bg-rose-500/20 border border-rose-500/20 shadow-sm shadow-rose-500/30 animate-pulse">
                                        <i class="fa-solid fa-triangle-exclamation mr-1 text-[8px]"></i>{{ number_format($log->suhu_tubuh, 1) }}°C
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 max-w-[150px]">
                                @if($log->catatan)
                                    <span class="text-[10px] text-white/50 italic truncate block" title="{{ $log->catatan }}">{{ $log->catatan }}</span>
                                @else
                                    <span class="text-[10px] text-white/25">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <div class="inline-flex items-center justify-center space-x-1.5 opacity-70 group-hover:opacity-100 transition-opacity">
                                    <!-- Edit -->
                                    <a href="{{ route('perjalanan.edit', $log->id) }}" class="p-2 bg-amber-500/10 hover:bg-amber-500/25 border border-amber-500/20 text-amber-300 rounded-lg transition-all hover:-translate-y-0.5" title="Ubah Data">
                                        <i class="fa-regular fa-pen-to-square text-sm"></i>
                                    </a>
                                    <!-- Delete -->
                                    <button type="button" 
                                            @click="deleteUrl = '{{ route('perjalanan.destroy', $log->id) }}'; openDeleteModal = true"
                                            class="p-2 bg-rose-500/10 hover:bg-rose-500/25 border border-rose-500/20 text-rose-300 rounded-lg transition-all cursor-pointer hover:-translate-y-0.5" 
                                            title="Hapus Data">
                                        <i class="fa-regular fa-trash-can text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-16 text-center text-white/50">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center text-white/20 text-2xl border border-white/10">
                                        <i class="fa-solid fa-clipboard-question"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm text-white/60">Tidak ada log perjalanan</p>
                                        <p class="text-[10px] text-white/35 mt-1">Belum ada data yang sesuai dengan filter Anda</p>
                                    </div>
                                    <a href="{{ route('perjalanan.create') }}" class="mt-2 inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-cyan-500/15 border border-cyan-500/25 text-cyan-300 text-xs font-semibold hover:bg-cyan-500/25 transition-all">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                        <span>Tambah Catatan Pertama</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Elegant Delete Confirmation Modal -->
        <div x-show="openDeleteModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm"
             style="display: none;">
             
             <div class="w-full max-w-sm bg-slate-950/95 border border-white/20 rounded-2xl p-6 shadow-2xl backdrop-blur-xl transform transition-all duration-300"
                  @click.away="openDeleteModal = false">
                  
                  <div class="flex items-start space-x-3 text-xs">
                      <div class="w-10 h-10 rounded-xl bg-rose-500/20 border border-rose-500/30 flex items-center justify-center text-rose-400 shrink-0">
                          <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                      </div>
                      <div class="flex-1">
                          <h3 class="text-sm font-bold text-white">Konfirmasi Hapus</h3>
                          <p class="text-white/60 mt-1.5 body-font leading-relaxed">Apakah Anda yakin ingin menghapus catatan perjalanan ini secara permanen? Data yang dihapus tidak dapat dikembalikan.</p>
                      </div>
                  </div>
                  
                  <div class="mt-6 flex justify-end space-x-2.5 text-xs">
                      <button type="button" 
                              @click="openDeleteModal = false" 
                              class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-white font-semibold transition-all duration-300 cursor-pointer">
                          Batal
                      </button>
                      <form :action="deleteUrl" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" 
                                  class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold transition-all duration-300 cursor-pointer shadow-lg shadow-rose-600/20">
                              <i class="fa-solid fa-trash mr-1"></i>Hapus
                          </button>
                      </form>
                  </div>
             </div>
        </div>

    </div>

</div>
@endsection
