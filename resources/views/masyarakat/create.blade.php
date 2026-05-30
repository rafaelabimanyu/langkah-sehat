@extends('layouts.app')

@section('title', __('Catat Perjalanan Baru'))

@section('content')
<div class="max-w-2xl mx-auto my-4 sm:my-8">
    
    <!-- Breadcrumb -->
    <div class="flex items-center space-x-2 text-[10px] text-slate-400 mb-6 font-medium">
        <a href="{{ route('masyarakat.dashboard') }}" class="hover:text-[#4a7a8a] transition-colors">{{ __('Dashboard') }}</a>
        <i class="fa-solid fa-chevron-right text-[7px]"></i>
        <span class="text-slate-600">{{ __('Catat Perjalanan') }}</span>
    </div>

    <!-- Form Container - High-Fidelity Glassmorphic Card -->
    <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-xl rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300">
        
        <!-- Form Header -->
        <div class="flex items-center space-x-3 mb-8 relative z-10">
            <div class="w-11 h-11 rounded-full bg-[#5c8d9d]/10 text-[#4a7a8a] flex items-center justify-center border border-[#5c8d9d]/20">
                <i class="fa-solid fa-map-pin text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl font-extrabold tracking-tight text-[#1a365d]">{{ __('Catat Perjalanan Baru') }}</h2>
                <p class="text-xs text-slate-500 mt-0.5 body-font">{{ __('Lengkapi data kunjungan dan kondisi fisik Anda') }}</p>
            </div>
        </div>

        <!-- Divider -->
        <div class="h-px bg-slate-100 mb-7"></div>

        <!-- Form Body -->
        <form action="{{ route('perjalanan.store') }}" method="POST" class="space-y-6 relative z-10 body-font">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Date input -->
                <div class="space-y-2">
                    <label for="tanggal" class="flex items-center space-x-2 text-xs font-semibold text-slate-500 tracking-wider uppercase">
                        <i class="fa-regular fa-calendar text-[#7da8b6] text-[10px]"></i>
                        <span>{{ __('Tanggal') }} <span class="text-rose-500">*</span></span>
                    </label>
                    <div class="relative">
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                            class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all duration-300 shadow-sm">
                    </div>
                    @error('tanggal')
                        <p class="text-[10px] text-rose-500 font-medium flex items-center space-x-1"><i class="fa-solid fa-circle-exclamation"></i><span>{{ $message }}</span></p>
                    @enderror
                </div>
                
                <!-- Time input -->
                <div class="space-y-2">
                    <label for="jam" class="flex items-center space-x-2 text-xs font-semibold text-slate-500 tracking-wider uppercase">
                        <i class="fa-regular fa-clock text-[#7da8b6] text-[10px]"></i>
                        <span>{{ __('Jam') }} <span class="text-rose-500">*</span></span>
                    </label>
                    <div class="relative">
                        <input type="time" name="jam" id="jam" value="{{ old('jam', date('H:i')) }}" required
                            class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all duration-300 shadow-sm">
                    </div>
                    @error('jam')
                        <p class="text-[10px] text-rose-500 font-medium flex items-center space-x-1"><i class="fa-solid fa-circle-exclamation"></i><span>{{ $message }}</span></p>
                    @enderror
                </div>
            </div>

            <!-- Location input -->
            <div class="space-y-2">
                <label for="lokasi" class="flex items-center space-x-2 text-xs font-semibold text-slate-500 tracking-wider uppercase">
                    <i class="fa-solid fa-location-dot text-[#7da8b6] text-[10px]"></i>
                    <span>{{ __('Lokasi Kunjungan') }} <span class="text-rose-500">*</span></span>
                </label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required
                    class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all duration-300 shadow-sm"
                    placeholder="{{ __('Contoh: Gedung Perkantoran Sudirman, Stasiun Kota') }}">
                @error('lokasi')
                    <p class="text-[10px] text-rose-500 font-medium flex items-center space-x-1"><i class="fa-solid fa-circle-exclamation"></i><span>{{ $message }}</span></p>
                @enderror
            </div>

            <!-- Temperature input -->
            <div class="space-y-2">
                <label for="suhu_tubuh" class="flex items-center space-x-2 text-xs font-semibold text-slate-500 tracking-wider uppercase">
                    <i class="fa-solid fa-thermometer text-[#7da8b6] text-[10px]"></i>
                    <span>{{ __('Suhu Tubuh') }} (°C) <span class="text-rose-500">*</span></span>
                </label>
                <input type="number" step="0.1" name="suhu_tubuh" id="suhu_tubuh" value="{{ old('suhu_tubuh') }}" required
                    class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all duration-300 shadow-sm"
                    placeholder="{{ __('Contoh: 36.6 (Rentang: 35.0 - 42.0)') }}">
                <p class="text-[10px] text-slate-400 flex items-center space-x-1">
                    <i class="fa-solid fa-info-circle"></i>
                    <span>{{ __('Suhu ≥ 37.5°C akan memicu peringatan status kesehatan') }}</span>
                </p>
                @error('suhu_tubuh')
                    <p class="text-[10px] text-rose-500 font-medium flex items-center space-x-1"><i class="fa-solid fa-circle-exclamation"></i><span>{{ $message }}</span></p>
                @enderror
            </div>

            <!-- Note input -->
            <div class="space-y-2">
                <label for="catatan" class="flex items-center space-x-2 text-xs font-semibold text-slate-500 tracking-wider uppercase">
                    <i class="fa-solid fa-note-sticky text-[#7da8b6] text-[10px]"></i>
                    <span>{{ __('Catatan Tambahan (Opsional)') }}</span>
                </label>
                <textarea name="catatan" id="catatan" rows="4"
                    class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all duration-300 resize-none shadow-sm"
                    placeholder="{{ __('Tulis keluhan kesehatan atau catatan dari dokter/petugas medis...') }}">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="text-[10px] text-rose-500 font-medium flex items-center space-x-1"><i class="fa-solid fa-circle-exclamation"></i><span>{{ $message }}</span></p>
                @enderror
            </div>

            <!-- Divider -->
            <div class="h-px bg-slate-100"></div>

            <!-- Action buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                <a href="{{ route('masyarakat.dashboard') }}" 
                   class="w-full sm:w-auto text-center px-6 py-3 rounded-full bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 hover:text-slate-800 font-semibold text-sm transition-all duration-300">
                    <i class="fa-solid fa-arrow-left mr-2 text-xs"></i>{{ __('Kembali') }}
                </a>
                <button type="submit" 
                        class="w-full sm:w-auto px-8 py-3 bg-[#4a7a8a] hover:bg-[#3b6370] text-white font-bold rounded-full text-sm tracking-wide shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer">
                    <i class="fa-solid fa-paper-plane mr-2"></i>{{ __('Simpan Catatan Baru') }}
                </button>
            </div>
        </form>

    </div>

    <!-- Quick Info Below Form -->
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white/80 backdrop-blur-md border border-slate-200 rounded-2xl p-4 flex items-start space-x-3 shadow-sm">
            <div class="w-7 h-7 rounded-full bg-[#5c8d9d]/10 text-[#4a7a8a] flex items-center justify-center shrink-0 mt-0.5 border border-[#5c8d9d]/20">
                <i class="fa-solid fa-circle-info text-xs"></i>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-600">{{ __('Data Otomatis') }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5 body-font leading-relaxed">{{ __('Tanggal dan jam terisi otomatis dengan waktu saat ini. Anda dapat mengubahnya.') }}</p>
            </div>
        </div>
        <div class="bg-white/80 backdrop-blur-md border border-slate-200 rounded-2xl p-4 flex items-start space-x-3 shadow-sm">
            <div class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 border border-emerald-100">
                <i class="fa-solid fa-shield-halved text-xs"></i>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-600">{{ __('Privasi Aman') }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5 body-font leading-relaxed">{{ __('Data Anda hanya bisa dilihat oleh Anda dan administrasi berwenang.') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
