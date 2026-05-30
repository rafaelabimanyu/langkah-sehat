@extends('layouts.app')

@section('title', __('Ubah Data Perjalanan'))
@section('page_header', __('Ubah Catatan Perjalanan'))

@section('content')
<div class="max-w-2xl mx-auto">
    
    <!-- Form Container -->
    <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-xl rounded-3xl p-8 relative overflow-hidden transition-all duration-300">
        
        <!-- Form Header -->
        <div class="flex items-center space-x-3 mb-6 relative z-10">
            <div class="w-10 h-10 rounded-full bg-[#5c8d9d]/10 text-[#4a7a8a] flex items-center justify-center border border-[#5c8d9d]/20">
                <i class="fa-regular fa-pen-to-square text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-[#1a365d]">{{ __('Ubah Catatan Perjalanan') }}</h2>
                <p class="text-xs text-slate-500">{{ __('Sesuaikan data log perjalanan Anda yang telah tersimpan.') }}</p>
            </div>
        </div>

        <!-- Form Body -->
        <form action="{{ route('perjalanan.update', $perjalanan->id) }}" method="POST" class="space-y-6 relative z-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Date input -->
                <div>
                    <label for="tanggal" class="block text-xs font-semibold text-slate-500 tracking-wider uppercase mb-2">{{ __('Tanggal Perjalanan') }} <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fa-regular fa-calendar"></i>
                        </span>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $perjalanan->tanggal) }}" required
                            class="w-full bg-white border border-slate-200 rounded-2xl pl-10 pr-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all shadow-sm">
                    </div>
                    @error('tanggal')
                        <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Time input -->
                <div>
                    <label for="jam" class="block text-xs font-semibold text-slate-500 tracking-wider uppercase mb-2">{{ __('Jam Perjalanan') }} <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fa-regular fa-clock"></i>
                        </span>
                        <input type="time" name="jam" id="jam" value="{{ old('jam', substr($perjalanan->jam, 0, 5)) }}" required
                            class="w-full bg-white border border-slate-200 rounded-2xl pl-10 pr-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all shadow-sm">
                    </div>
                    @error('jam')
                        <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Location input -->
            <div>
                <label for="lokasi" class="block text-xs font-semibold text-slate-500 tracking-wider uppercase mb-2">{{ __('Lokasi Kunjungan') }} <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fa-solid fa-location-dot"></i>
                    </span>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $perjalanan->lokasi) }}" required
                        class="w-full bg-white border border-slate-200 rounded-2xl pl-10 pr-4 py-2.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all shadow-sm"
                        placeholder="{{ __('Contoh: Terminal Bandara 3, Mall Kelapa Gading') }}">
                </div>
                @error('lokasi')
                    <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Temperature input -->
            <div>
                <label for="suhu_tubuh" class="block text-xs font-semibold text-slate-500 tracking-wider uppercase mb-2">{{ __('Suhu Tubuh') }} (°C) <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fa-solid fa-thermometer"></i>
                    </span>
                    <input type="number" step="0.1" name="suhu_tubuh" id="suhu_tubuh" value="{{ old('suhu_tubuh', $perjalanan->suhu_tubuh) }}" required
                        class="w-full bg-white border border-slate-200 rounded-2xl pl-10 pr-4 py-2.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all shadow-sm"
                        placeholder="Contoh: 36.5">
                </div>
                <p class="text-[10px] text-slate-400 mt-1.5">{{ __('Note: Suhu &ge; 37.5°C akan memicu peringatan status kesehatan.') }}</p>
                @error('suhu_tubuh')
                    <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Note / Catatan input -->
            <div>
                <label for="catatan" class="block text-xs font-semibold text-slate-500 tracking-wider uppercase mb-2">{{ __('Catatan Tambahan / Medis (Opsional)') }}</label>
                <textarea name="catatan" id="catatan" rows="4"
                    class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all shadow-sm"
                    placeholder="{{ __('Tulis keluhan kesehatan atau catatan dari dokter/petugas medis...') }}">{{ old('catatan', $perjalanan->catatan) }}</textarea>
                @error('catatan')
                    <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('perjalanan.riwayat') }}" 
                   class="px-5 py-2.5 rounded-full bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold transition-all duration-300">
                    {{ __('Batal') }}
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-[#4a7a8a] hover:bg-[#3b6370] text-white font-bold rounded-full shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer">
                    {{ __('Perbarui Catatan') }}
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
