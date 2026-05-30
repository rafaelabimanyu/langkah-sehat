@extends('layouts.app')

@section('title', __('Profil Saya'))

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="{
    previewUrl: null,
    fileChosen(event) {
        const file = event.target.files[0];
        if (file) {
            this.previewUrl = URL.createObjectURL(file);
        }
    }
}">
    
    <!-- Title & Back Button -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center space-x-3">
            <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('masyarakat.dashboard') }}" class="w-10 h-10 rounded-full bg-white hover:bg-slate-100 flex items-center justify-center text-slate-600 border border-slate-200 shadow-sm transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-[#1a365d]">{{ __('Profil Saya') }}</h1>
                <p class="text-xs text-slate-500 mt-1">{{ __('Sunting profil, ganti kata sandi, atau ubah avatar Anda.') }}</p>
            </div>
        </div>
    </div>

    <!-- Main Container Card -->
    <div class="bg-white/80 backdrop-blur-lg border border-white/60 shadow-xl rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300">
        <!-- Decorative subtle glows -->
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-[#7da8b6]/15 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#5c8d9d]/10 rounded-full blur-3xl -z-10"></div>
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Centered Profile Picture Section -->
            <div class="text-center">
                <div class="relative group w-32 h-32 mx-auto mb-4">
                    <!-- Avatar circle -->
                    <div class="w-full h-full rounded-full overflow-hidden border-4 border-white shadow-md bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center relative">
                        <template x-if="previewUrl">
                            <img :src="previewUrl" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!previewUrl">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-[#4a7a8a] text-4xl font-extrabold select-none bg-[#edf3f6]">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                            @endif
                        </template>
                    </div>

                    <!-- Real-time upload trigger / Hover Icon -->
                    <label for="avatar-input" class="absolute inset-0 w-full h-full rounded-full bg-slate-900/50 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center text-white text-xs font-bold cursor-pointer transition-opacity duration-300 z-10 shadow-inner">
                        <i class="fa-solid fa-camera text-2xl mb-1 drop-shadow-md"></i>
                        <span>{{ __('Pilih Foto') }}</span>
                    </label>
                    <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*" @change="fileChosen">
                </div>
                
                @error('avatar')
                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @else
                    <p class="text-[11px] text-slate-400 font-semibold">{{ __('Format: JPG, PNG, GIF (Maks. 2MB)') }}</p>
                @enderror
            </div>

            <!-- Profile Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Nama Lengkap') }}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all bg-white/50 @error('name') border-rose-300 @enderror">
                    </div>
                    @error('name')
                        <p class="text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Alamat Email') }}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all bg-white/50 @error('email') border-rose-300 @enderror">
                    </div>
                    @error('email')
                        <p class="text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Kata Sandi Baru') }}</label>
                    <div class="relative" x-data="{ show: false }">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input :type="show ? 'text' : 'password'" id="password" name="password"
                               placeholder="••••••••"
                               class="w-full pl-11 pr-10 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all bg-white/50 @error('password') border-rose-300 @enderror">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 font-medium">{{ __('Kosongkan jika tidak ingin mengubah kata sandi.') }}</p>
                    @error('password')
                        <p class="text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Konfirmasi Kata Sandi') }}</label>
                    <div class="relative" x-data="{ show: false }">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input :type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation"
                               placeholder="••••••••"
                               class="w-full pl-11 pr-10 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#7da8b6] focus:border-transparent transition-all bg-white/50">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4">
                <button type="submit" class="w-full sm:w-auto bg-[#4a7a8a] hover:bg-[#3b6370] text-white font-bold px-8 py-3 rounded-full shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5 cursor-pointer text-sm">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>{{ __('Simpan Perubahan') }}
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
