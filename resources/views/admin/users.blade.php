@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('page_header', 'Manajemen Pengguna Terdaftar')

@section('content')
<div class="space-y-6">
    
    <!-- Info Header Card -->
    <div class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl p-6 transition-all duration-300">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-xl bg-cyan-500/20 text-cyan-300 flex items-center justify-center border border-cyan-500/20">
                <i class="fa-solid fa-users-gear text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold">Manajemen Pengguna</h2>
                <p class="text-xs text-white/50">Kelola akun masyarakat, tinjau aktivitas pengumpulan data, dan lakukan pembersihan data bermasalah.</p>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl overflow-hidden transition-all duration-300" x-data="{ openDeleteModal: false, deleteUrl: '' }">
        
        <div class="px-6 py-4 bg-white/5 border-b border-white/10 flex items-center justify-between">
            <h3 class="font-bold text-base text-cyan-300 flex items-center space-x-2">
                <i class="fa-solid fa-list-ul"></i>
                <span>Tabel Anggota & Hak Akses</span>
            </h3>
            <span class="text-xs text-white/50">Total Pengguna: <strong class="text-white">{{ $users->count() }}</strong></span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 border-b border-white/10">
                        <th class="px-6 py-4 text-xs font-semibold text-white/70 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/70 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/70 uppercase tracking-wider">Alamat Email</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/70 uppercase tracking-wider">Tanggal Bergabung</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/70 uppercase tracking-wider">Total Catatan Log</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/70 uppercase tracking-wider text-center">Tindakan Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $index => $userItem)
                        <tr class="hover:bg-white/5 transition-all duration-200">
                            <!-- No -->
                            <td class="px-6 py-4 text-sm text-white/60 font-medium">{{ $index + 1 }}</td>
                            
                            <!-- Name & Role Badge -->
                            <td class="px-6 py-4 text-sm font-semibold">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center font-bold text-xs text-white/70">
                                        {{ strtoupper(substr($userItem->name, 0, 2)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-white">{{ $userItem->name }}</span>
                                        <span class="text-[10px] text-white/40 mt-0.5 capitalize">
                                            @if($userItem->role === 'admin')
                                                <span class="text-cyan-300 font-bold bg-cyan-500/10 px-1.5 py-0.5 rounded">Admin</span>
                                            @else
                                                <span class="text-white/60 bg-white/5 px-1.5 py-0.5 rounded">Masyarakat</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Email -->
                            <td class="px-6 py-4 text-sm text-white/80">
                                {{ $userItem->email }}
                            </td>
                            
                            <!-- Joined Date -->
                            <td class="px-6 py-4 text-sm text-white/70">
                                {{ \Carbon\Carbon::parse($userItem->created_at)->translatedFormat('d F Y') }}
                            </td>
                            
                            <!-- Total Submitted Logs -->
                            <td class="px-6 py-4 text-sm font-bold text-center sm:text-left">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $userItem->perjalanans_count > 0 ? 'bg-cyan-500/20 text-cyan-300' : 'bg-white/5 text-white/40' }}">
                                    {{ $userItem->perjalanans_count }} Log
                                </span>
                            </td>
                            
                            <!-- Administrative Action -->
                            <td class="px-6 py-4 text-sm text-center">
                                @if($userItem->id !== Auth::id())
                                    <button type="button" 
                                            @click="deleteUrl = '{{ route('admin.users.destroy', $userItem->id) }}'; openDeleteModal = true"
                                            class="px-3 py-1.5 bg-rose-500/15 hover:bg-rose-500/25 border border-rose-500/20 text-rose-300 hover:text-white rounded-lg hover:-translate-y-0.5 transition-all duration-300 cursor-pointer text-xs font-bold"
                                            title="Hapus Akun Pengguna">
                                        <i class="fa-solid fa-user-minus mr-1"></i>Hapus Akun
                                    </button>
                                @else
                                    <span class="text-xs text-white/30 italic">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-white/50">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <p class="font-medium text-base text-white/70">Tidak ada pengguna terdaftar</p>
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
                          <h3 class="text-lg font-bold text-white">Hapus Akun Pengguna</h3>
                          <p class="text-sm text-white/60 mt-1 body-font">Apakah Anda yakin ingin menghapus akun pengguna ini? Seluruh catatan perjalanan terkait pengguna ini juga akan ikut terhapus secara permanen dari basis data.</p>
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
