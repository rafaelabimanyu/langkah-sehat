@extends('layouts.app')

@section('title', 'Catat Perjalanan Baru')

@section('content')
<div class="max-w-2xl mx-auto my-4 sm:my-8">
    
    <!-- Breadcrumb -->
    <div class="flex items-center space-x-2 text-[10px] text-white/40 mb-6 font-medium">
        <a href="{{ route('masyarakat.dashboard') }}" class="hover:text-cyan-300 transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[7px]"></i>
        <span class="text-white/70">Catat Perjalanan</span>
    </div>

    <!-- Form Container - High-Fidelity Glassmorphic Card -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-2xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300 hover:border-white/30">
        
        <!-- Decorative Glow Effects -->
        <div class="absolute -top-12 -left-12 w-32 h-32 bg-cyan-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-12 -right-12 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>
        
        <!-- Form Header -->
        <div class="flex items-center space-x-3 mb-8 relative z-10">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-cyan-500/30 to-emerald-500/30 text-cyan-300 flex items-center justify-center border border-cyan-500/30 shadow-[0_0_20px_rgba(6,182,212,0.2)]">
                <i class="fa-solid fa-map-pin text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl font-extrabold tracking-tight">Catat Perjalanan Baru</h2>
                <p class="text-xs text-white/50 mt-0.5 body-font">Lengkapi data kunjungan dan kondisi fisik Anda</p>
            </div>
        </div>

        <!-- Divider -->
        <div class="h-px bg-gradient-to-r from-transparent via-white/15 to-transparent mb-7"></div>

        <!-- Form Body -->
        <form action="{{ route('perjalanan.store') }}" method="POST" class="space-y-6 relative z-10 body-font">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Date input -->
                <div class="space-y-2">
                    <label for="tanggal" class="flex items-center space-x-2 text-xs font-semibold text-white/70 tracking-wider uppercase">
                        <i class="fa-regular fa-calendar text-cyan-400/60 text-[10px]"></i>
                        <span>Tanggal <span class="text-rose-400">*</span></span>
                    </label>
                    <div class="relative">
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400/30 focus:bg-white/10 transition-all duration-300 hover:border-white/20">
                    </div>
                    @error('tanggal')
                        <p class="text-[10px] text-rose-300 font-medium flex items-center space-x-1"><i class="fa-solid fa-circle-exclamation"></i><span>{{ $message }}</span></p>
                    @enderror
                </div>
                
                <!-- Time input -->
                <div class="space-y-2">
                    <label for="jam" class="flex items-center space-x-2 text-xs font-semibold text-white/70 tracking-wider uppercase">
                        <i class="fa-regular fa-clock text-cyan-400/60 text-[10px]"></i>
                        <span>Jam <span class="text-rose-400">*</span></span>
                    </label>
                    <div class="relative">
                        <input type="time" name="jam" id="jam" value="{{ old('jam', date('H:i')) }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400/30 focus:bg-white/10 transition-all duration-300 hover:border-white/20">
                    </div>
                    @error('jam')
                        <p class="text-[10px] text-rose-300 font-medium flex items-center space-x-1"><i class="fa-solid fa-circle-exclamation"></i><span>{{ $message }}</span></p>
                    @enderror
                </div>
            </div>

            <!-- Location input -->
            <div class="space-y-2">
                <label for="lokasi" class="flex items-center space-x-2 text-xs font-semibold text-white/70 tracking-wider uppercase">
                    <i class="fa-solid fa-location-dot text-cyan-400/60 text-[10px]"></i>
                    <span>Lokasi Kunjungan <span class="text-rose-400">*</span></span>
                </label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400/30 focus:bg-white/10 transition-all duration-300 hover:border-white/20"
                    placeholder="Contoh: Gedung Perkantoran Sudirman, Stasiun Kota">
                @error('lokasi')
                    <p class="text-[10px] text-rose-300 font-medium flex items-center space-x-1"><i class="fa-solid fa-circle-exclamation"></i><span>{{ $message }}</span></p>
                @enderror
            </div>

            <!-- Temperature input -->
            <div class="space-y-2">
                <label for="suhu_tubuh" class="flex items-center space-x-2 text-xs font-semibold text-white/70 tracking-wider uppercase">
                    <i class="fa-solid fa-thermometer text-cyan-400/60 text-[10px]"></i>
                    <span>Suhu Tubuh (°C) <span class="text-rose-400">*</span></span>
                </label>
                <input type="number" step="0.1" name="suhu_tubuh" id="suhu_tubuh" value="{{ old('suhu_tubuh') }}" required
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400/30 focus:bg-white/10 transition-all duration-300 hover:border-white/20"
                    placeholder="Contoh: 36.6 (Rentang: 35.0 - 42.0)">
                <p class="text-[10px] text-white/35 flex items-center space-x-1">
                    <i class="fa-solid fa-info-circle"></i>
                    <span>Suhu ≥ 37.5°C akan memicu peringatan status kesehatan</span>
                </p>
                @error('suhu_tubuh')
                    <p class="text-[10px] text-rose-300 font-medium flex items-center space-x-1"><i class="fa-solid fa-circle-exclamation"></i><span>{{ $message }}</span></p>
                @enderror
            </div>

            <!-- Note input -->
            <div class="space-y-2">
                <label for="catatan" class="flex items-center space-x-2 text-xs font-semibold text-white/70 tracking-wider uppercase">
                    <i class="fa-solid fa-note-sticky text-cyan-400/60 text-[10px]"></i>
                    <span>Catatan Tambahan (Opsional)</span>
                </label>
                <textarea name="catatan" id="catatan" rows="4"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400/30 focus:bg-white/10 transition-all duration-300 hover:border-white/20 resize-none"
                    placeholder="Tulis keluhan kesehatan atau catatan dari dokter/petugas medis...">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="text-[10px] text-rose-300 font-medium flex items-center space-x-1"><i class="fa-solid fa-circle-exclamation"></i><span>{{ $message }}</span></p>
                @enderror
            </div>

            <!-- Divider -->
            <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

            <!-- Action buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                <a href="{{ route('masyarakat.dashboard') }}" 
                   class="w-full sm:w-auto text-center px-6 py-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-white/80 hover:text-white font-semibold text-sm transition-all duration-300 hover:-translate-y-0.5">
                    <i class="fa-solid fa-arrow-left mr-2 text-xs"></i>Kembali
                </a>
                <button type="submit" 
                        class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-cyan-500 to-emerald-500 hover:from-cyan-600 hover:to-emerald-600 border-none rounded-xl text-slate-950 font-bold text-sm tracking-wide shadow-lg shadow-cyan-500/20 hover:shadow-[0_0_20px_rgba(34,211,238,0.5)] hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 cursor-pointer">
                    <i class="fa-solid fa-paper-plane mr-2"></i>Simpan Catatan Baru
                </button>
            </div>
        </form>

    </div>

    <!-- Quick Info Below Form -->
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl p-4 flex items-start space-x-3">
            <div class="w-7 h-7 rounded-lg bg-cyan-500/15 text-cyan-400/70 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fa-solid fa-circle-info text-xs"></i>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-white/60">Data Otomatis</p>
                <p class="text-[10px] text-white/40 mt-0.5 body-font leading-relaxed">Tanggal dan jam terisi otomatis dengan waktu saat ini. Anda dapat mengubahnya sesuai kebutuhan.</p>
            </div>
        </div>
        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl p-4 flex items-start space-x-3">
            <div class="w-7 h-7 rounded-lg bg-emerald-500/15 text-emerald-400/70 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fa-solid fa-shield-halved text-xs"></i>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-white/60">Privasi Aman</p>
                <p class="text-[10px] text-white/40 mt-0.5 body-font leading-relaxed">Data Anda hanya bisa dilihat oleh Anda dan petugas administrasi berwenang.</p>
            </div>
        </div>
    </div>
</div>
@endsection
