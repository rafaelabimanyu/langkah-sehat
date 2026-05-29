@extends('layouts.app')

@section('title', 'Masyarakat Dashboard')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- LEFT COLUMN: Analytics & Input Form (Takes 5 cols on lg) -->
    <div class="lg:col-span-5 space-y-6">
        
        <!-- Greeting Card Upgraded -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-6 relative overflow-hidden transition-all duration-300 hover:border-white/30">
            
            <!-- Abstract decorative glowing glass ring/pulse -->
            <div class="absolute -top-8 -right-8 w-24 h-24 bg-gradient-to-tr from-cyan-400 to-emerald-400 rounded-full opacity-35 blur-xl animate-pulse"></div>
            <div class="absolute top-5 right-5 text-cyan-400/40 text-3xl animate-bounce" style="animation-duration: 3s;">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>
            
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <h2 class="text-xl font-extrabold tracking-tight">Halo, {{ Auth::user()->name }}!</h2>
                    <p class="text-xs text-white/50 mt-1 body-font">Selamat datang di portal pelacakan perjalanan & suhu tubuh.</p>
                    
                    <div class="mt-4 inline-flex items-center space-x-2">
                        <span class="text-xs font-semibold text-white/60 tracking-wider">Status Kesehatan:</span>
                        @if($healthStatus === 'Normal')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-emerald-300 bg-emerald-500/20 border border-emerald-500/30 shadow-[0_0_12px_rgba(16,185,129,0.2)]">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-2 animate-pulse"></span>Normal
                            </span>
                        @elseif($healthStatus === 'Belum Ada Data')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-white/70 bg-white/10 border border-white/10">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/40 mr-2"></span>Belum Ada Data
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-rose-300 bg-rose-500/20 border border-rose-500/30 shadow-[0_0_12px_rgba(244,63,94,0.4)] animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400 mr-2"></span>{{ $healthStatus }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Unified Micro-Infographic Metrics Card -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-6 relative overflow-hidden transition-all duration-300 hover:border-white/30">
            <div class="absolute -bottom-8 -left-8 w-20 h-20 bg-indigo-500/10 rounded-full blur-xl"></div>
            
            <h4 class="text-xs font-semibold text-white/50 tracking-wider uppercase mb-4">Informasi Kesehatan Ringkas</h4>
            <div class="grid grid-cols-2 gap-6 divide-x divide-white/10">
                <!-- Total Logs -->
                <div class="space-y-2">
                    <p class="text-[10px] font-semibold text-white/40 uppercase tracking-widest">Total Perjalanan</p>
                    <div class="flex items-baseline space-x-2">
                        <span class="text-3xl font-black text-white tracking-tight">{{ $totalLogs }}</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold text-cyan-300 bg-cyan-500/20 border border-cyan-500/30 shadow-[0_0_10px_rgba(6,182,212,0.3)] uppercase">Log</span>
                    </div>
                </div>
                
                <!-- Average Temp -->
                <div class="space-y-2 pl-6">
                    <p class="text-[10px] font-semibold text-white/40 uppercase tracking-widest">Rata-Rata Suhu</p>
                    @if($avgTemp > 0)
                        <div class="flex items-baseline space-x-1 animate-pulse">
                            <span class="text-3xl font-black text-cyan-400 tracking-tight">{{ number_format($avgTemp, 1) }}</span>
                            <span class="text-sm font-bold text-cyan-400">°C</span>
                        </div>
                    @else
                        <span class="text-3xl font-black text-white/30 tracking-tight">-</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Embedded Input Form Card -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-6 relative overflow-hidden transition-all duration-300 hover:border-white/30">
            <div class="absolute -top-10 -left-10 w-20 h-20 bg-emerald-500/10 rounded-full blur-xl"></div>
            
            <div class="flex items-center space-x-2.5 mb-5 relative z-10">
                <div class="w-9 h-9 rounded-lg bg-cyan-500/20 text-cyan-300 flex items-center justify-center border border-cyan-500/30 shadow-[0_0_15px_rgba(6,182,212,0.2)]">
                    <i class="fa-solid fa-map-pin"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm">Catat Perjalanan Baru</h3>
                    <p class="text-[10px] text-white/40">Kirim data log kunjungan baru secara instan</p>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('perjalanan.store') }}" method="POST" class="space-y-4 relative z-10 body-font text-xs">
                @csrf
                
                <div class="grid grid-cols-2 gap-4">
                    <!-- Date input -->
                    <div>
                        <label for="tanggal" class="block text-[10px] font-semibold text-white/60 uppercase tracking-wider mb-1.5">Tanggal <span class="text-rose-400">*</span></label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all duration-300">
                        @error('tanggal')
                            <p class="text-[10px] text-rose-300 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Time input -->
                    <div>
                        <label for="jam" class="block text-[10px] font-semibold text-white/60 uppercase tracking-wider mb-1.5">Jam <span class="text-rose-400">*</span></label>
                        <input type="time" name="jam" id="jam" value="{{ old('jam', date('H:i')) }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all duration-300">
                        @error('jam')
                            <p class="text-[10px] text-rose-300 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location input -->
                <div>
                    <label for="lokasi" class="block text-[10px] font-semibold text-white/60 uppercase tracking-wider mb-1.5">Lokasi Kunjungan <span class="text-rose-400">*</span></label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all duration-300"
                        placeholder="Contoh: Gedung Perkantoran Sudirman, Stasiun Kota">
                    @error('lokasi')
                        <p class="text-[10px] text-rose-300 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Temperature input -->
                <div>
                    <label for="suhu_tubuh" class="block text-[10px] font-semibold text-white/60 uppercase tracking-wider mb-1.5">Suhu Tubuh (°C) <span class="text-rose-400">*</span></label>
                    <input type="number" step="0.1" name="suhu_tubuh" id="suhu_tubuh" value="{{ old('suhu_tubuh') }}" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all duration-300"
                        placeholder="Contoh: 36.6 (Rentang: 35.0 - 42.0)">
                    @error('suhu_tubuh')
                        <p class="text-[10px] text-rose-300 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan input -->
                <div>
                    <label for="catatan" class="block text-[10px] font-semibold text-white/60 uppercase tracking-wider mb-1.5">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan" id="catatan" rows="3"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all duration-300"
                        placeholder="Tulis keluhan atau catatan kesehatan lainnya di sini...">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="text-[10px] text-rose-300 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button with active glow and scaling -->
                <button type="submit" 
                        class="w-full py-3 bg-gradient-to-r from-cyan-500 to-emerald-500 hover:from-cyan-600 hover:to-emerald-600 border-none rounded-xl text-slate-950 font-bold tracking-wide shadow-md hover:shadow-[0_0_20px_rgba(34,211,238,0.5)] hover:-translate-y-0.5 transition-all duration-300 cursor-pointer">
                    Simpan Catatan Baru
                </button>

            </form>
        </div>

    </div>

    <!-- RIGHT COLUMN: Travel History Logs Table & Educational Insights (Takes 7 cols on lg) -->
    <div class="lg:col-span-7 space-y-6">
        
        <!-- Table Search & Filter Header -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-6 transition-all duration-300 hover:border-white/30">
            <form action="{{ route('masyarakat.dashboard') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <!-- Search -->
                <div>
                    <input type="text" name="search" value="{{ $search }}"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all duration-300"
                        placeholder="Cari lokasi...">
                </div>
                
                <!-- Date -->
                <div>
                    <input type="date" name="filter_tanggal" value="{{ $filterTanggal }}"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all duration-300">
                </div>
                
                <!-- Temp Filter & Buttons -->
                <div class="flex items-center space-x-2">
                    <select name="filter_suhu"
                        class="flex-1 bg-slate-900 border border-white/10 rounded-xl px-3 py-3 text-xs text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all duration-300">
                        <option value="">Status Suhu</option>
                        <option value="normal" {{ $filterSuhu === 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="demam" {{ $filterSuhu === 'demam' ? 'selected' : '' }}>Demam (Alert)</option>
                    </select>
                    
                    <button type="submit" class="bg-white/10 hover:bg-white/25 border border-white/20 text-white p-3 rounded-xl transition-all hover:-translate-y-0.5 cursor-pointer text-xs" title="Terapkan Filter">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                    
                    @if($search || $filterTanggal || $filterSuhu)
                        <a href="{{ route('masyarakat.dashboard') }}" class="bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-300 p-3 rounded-xl transition-all hover:-translate-y-0.5 text-xs flex items-center justify-center" title="Reset Filter">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- History Table Card -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl overflow-hidden transition-all duration-300 hover:border-white/30" x-data="{ openDeleteModal: false, deleteUrl: '' }">
            
            <div class="px-5 py-4 bg-white/5 border-b border-white/10 flex items-center justify-between">
                <h3 class="font-bold text-sm text-cyan-300 flex items-center space-x-2">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Tabel Riwayat Perjalanan</span>
                </h3>
                <span class="text-[10px] text-white/50 font-medium">Tampil: <strong>{{ $perjalanans->count() }}</strong> entri</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/5 border-b border-white/10">
                            <th class="px-4 py-3 text-[10px] font-semibold text-white/70 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-[10px] font-semibold text-white/70 uppercase tracking-wider">Waktu Kunjungan</th>
                            <th class="px-4 py-3 text-[10px] font-semibold text-white/70 uppercase tracking-wider">Lokasi</th>
                            <th class="px-4 py-3 text-[10px] font-semibold text-white/70 uppercase tracking-wider">Suhu</th>
                            <th class="px-4 py-3 text-[10px] font-semibold text-white/70 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($perjalanans as $index => $log)
                            <tr class="hover:bg-white/5 transition-all duration-200 text-xs">
                                <td class="px-4 py-3.5 text-white/60 font-medium">{{ $index + 1 }}</td>
                                <td class="px-4 py-3.5 font-semibold">
                                    <div class="flex flex-col">
                                        <span>{{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M Y') }}</span>
                                        <span class="text-[10px] text-white/40 mt-0.5"><i class="fa-regular fa-clock mr-1"></i>{{ substr($log->jam, 0, 5) }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 font-semibold text-cyan-300 max-w-[150px] truncate" title="{{ $log->lokasi }}">
                                    <span>{{ $log->lokasi }}</span>
                                    @if($log->catatan)
                                        <span class="block text-[9px] font-normal text-white/50 mt-0.5 italic truncate" title="{{ $log->catatan }}">{{ $log->catatan }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5">
                                    @if($log->suhu_tubuh < 37.5)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold text-emerald-300 bg-emerald-500/20 border border-emerald-500/10">
                                            {{ number_format($log->suhu_tubuh, 1) }}°C
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold text-rose-300 bg-rose-500/20 border border-rose-500/10 shadow-sm shadow-rose-500/50 animate-pulse">
                                            {{ number_format($log->suhu_tubuh, 1) }}°C
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <div class="inline-flex items-center justify-center space-x-1.5">
                                        <!-- Edit -->
                                        <a href="{{ route('perjalanan.edit', $log->id) }}" class="p-2 bg-amber-500/10 hover:bg-amber-500/25 border border-amber-500/20 text-amber-300 rounded-lg transition-all" title="Ubah Data">
                                            <i class="fa-regular fa-pen-to-square text-sm"></i>
                                        </a>
                                        <!-- Delete -->
                                        <button type="button" 
                                                @click="deleteUrl = '{{ route('perjalanan.destroy', $log->id) }}'; openDeleteModal = true"
                                                class="p-2 bg-rose-500/10 hover:bg-rose-500/25 border border-rose-500/20 text-rose-300 rounded-lg transition-all cursor-pointer" 
                                                title="Hapus Data">
                                            <i class="fa-regular fa-trash-can text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-white/50">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center text-white/30 text-xl border border-white/10">
                                            <i class="fa-solid fa-clipboard-question"></i>
                                        </div>
                                        <p class="font-medium text-xs text-white/70">Tidak ada log perjalanan</p>
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
                 
                 <div class="w-full max-w-sm bg-slate-950 border border-white/20 rounded-2xl p-5 shadow-2xl transform transition-all duration-300"
                      @click.away="openDeleteModal = false">
                      
                      <div class="flex items-start space-x-3 text-xs">
                          <div class="w-8 h-8 rounded-full bg-rose-500/20 border border-rose-500/30 flex items-center justify-center text-rose-400 shrink-0">
                              <i class="fa-solid fa-triangle-exclamation text-base"></i>
                          </div>
                          <div class="flex-1">
                              <h3 class="text-sm font-bold text-white">Konfirmasi Hapus</h3>
                              <p class="text-white/60 mt-1 body-font">Apakah Anda yakin ingin menghapus catatan perjalanan ini secara permanen?</p>
                          </div>
                      </div>
                      
                      <div class="mt-5 flex justify-end space-x-2 text-xs">
                          <button type="button" 
                                  @click="openDeleteModal = false" 
                                  class="px-3.5 py-1.5 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-white font-semibold transition-all duration-300 cursor-pointer">
                              Batal
                          </button>
                          <form :action="deleteUrl" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" 
                                      class="px-3.5 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold transition-all duration-300 cursor-pointer">
                                  Hapus
                              </button>
                          </form>
                      </div>
                 </div>
            </div>

        </div>

        <!-- NEW COMPONENT: PUSAT EDUKASI & INFO KESEHATAN (Fills Right Column layout gaps) -->
        <div class="space-y-4">
            <h3 class="font-bold text-sm text-white/80 flex items-center space-x-2 px-1">
                <i class="fa-solid fa-circle-info text-cyan-300"></i>
                <span>Pusat Edukasi & Info Kesehatan</span>
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <!-- Card A: Tips Hari Ini -->
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-5 relative overflow-hidden transition-all duration-300 hover:border-white/30 group">
                    <div class="absolute -bottom-8 -right-8 w-20 h-20 bg-emerald-500/10 rounded-full blur-xl"></div>
                    
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
                
                <!-- Card B: Status Log & Kepatuhan -->
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-5 relative overflow-hidden transition-all duration-300 hover:border-white/30">
                    <div class="absolute -bottom-8 -right-8 w-20 h-20 bg-cyan-500/10 rounded-full blur-xl"></div>
                    
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
                        <div class="w-full h-1.5 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-cyan-400 to-emerald-400 transition-all duration-500" 
                                 style="width: {{ min($totalLogs * 20, 100) }}%"></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    </div>

</div>
@endsection
