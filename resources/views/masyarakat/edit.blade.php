@extends('layouts.app')

@section('title', 'Ubah Data Perjalanan')
@section('page_header', 'Ubah Catatan Perjalanan')

@section('content')
<div class="max-w-2xl mx-auto">
    
    <!-- Form Container -->
    <div class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl p-8 relative overflow-hidden transition-all duration-300">
        
        <!-- Decorative Glow Effects -->
        <div class="absolute -top-10 -left-10 w-24 h-24 bg-cyan-500/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -right-10 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl"></div>
        
        <!-- Form Header -->
        <div class="flex items-center space-x-3 mb-6 relative z-10">
            <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-300 flex items-center justify-center border border-amber-500/20">
                <i class="fa-regular fa-pen-to-square text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold">Ubah Catatan Perjalanan</h2>
                <p class="text-xs text-white/50">Sesuaikan data log perjalanan Anda yang telah tersimpan.</p>
            </div>
        </div>

        <!-- Form Body -->
        <form action="{{ route('perjalanan.update', $perjalanan->id) }}" method="POST" class="space-y-6 relative z-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Date input -->
                <div>
                    <label for="tanggal" class="block text-xs font-semibold text-white/70 tracking-wider uppercase mb-2">Tanggal Perjalanan <span class="text-rose-400">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/40">
                            <i class="fa-regular fa-calendar"></i>
                        </span>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $perjalanan->tanggal) }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/10 transition-all">
                    </div>
                    @error('tanggal')
                        <p class="text-xs text-rose-300 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Time input -->
                <div>
                    <label for="jam" class="block text-xs font-semibold text-white/70 tracking-wider uppercase mb-2">Jam Perjalanan <span class="text-rose-400">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/40">
                            <i class="fa-regular fa-clock"></i>
                        </span>
                        <input type="time" name="jam" id="jam" value="{{ old('jam', substr($perjalanan->jam, 0, 5)) }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/10 transition-all">
                    </div>
                    @error('jam')
                        <p class="text-xs text-rose-300 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Location input -->
            <div>
                <label for="lokasi" class="block text-xs font-semibold text-white/70 tracking-wider uppercase mb-2">Lokasi Kunjungan <span class="text-rose-400">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/40">
                        <i class="fa-solid fa-location-dot"></i>
                    </span>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $perjalanan->lokasi) }}" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/10 transition-all"
                        placeholder="Contoh: Terminal Bandara 3, Mall Kelapa Gading">
                </div>
                @error('lokasi')
                    <p class="text-xs text-rose-300 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Temperature input -->
            <div>
                <label for="suhu_tubuh" class="block text-xs font-semibold text-white/70 tracking-wider uppercase mb-2">Suhu Tubuh (°C) <span class="text-rose-400">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/40">
                        <i class="fa-solid fa-thermometer"></i>
                    </span>
                    <input type="number" step="0.1" name="suhu_tubuh" id="suhu_tubuh" value="{{ old('suhu_tubuh', $perjalanan->suhu_tubuh) }}" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/10 transition-all"
                        placeholder="Contoh: 36.5">
                </div>
                <p class="text-[10px] text-white/40 mt-1.5">Note: Suhu &ge; 37.5°C akan memicu peringatan status kesehatan.</p>
                @error('suhu_tubuh')
                    <p class="text-xs text-rose-300 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Note / Catatan input -->
            <div>
                <label for="catatan" class="block text-xs font-semibold text-white/70 tracking-wider uppercase mb-2">Catatan Tambahan / Medis (Opsional)</label>
                <textarea name="catatan" id="catatan" rows="4"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/10 transition-all"
                    placeholder="Masukkan keluhan kesehatan atau catatan dari dokter/petugas medis jika ada...">{{ old('catatan', $perjalanan->catatan) }}</textarea>
                @error('catatan')
                    <p class="text-xs text-rose-300 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-white/5">
                <a href="{{ route('masyarakat.dashboard') }}" 
                   class="px-5 py-2.5 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-white font-semibold transition-all duration-300 hover:-translate-y-0.5">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 border-none rounded-xl text-slate-950 font-bold shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 cursor-pointer">
                    Perbarui Catatan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
