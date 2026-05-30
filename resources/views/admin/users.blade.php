@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('page_header', 'Manajemen Pengguna Terdaftar')

@section('content')
<div class="space-y-6">
    
    <!-- Info Header Card -->
    <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-sm rounded-3xl p-6 transition-all duration-300">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-full bg-[#5c8d9d]/10 text-[#4a7a8a] flex items-center justify-center border border-[#5c8d9d]/20">
                <i class="fa-solid fa-users-gear text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-[#1a365d]">Manajemen Pengguna</h2>
                <p class="text-xs text-slate-500">Kelola akun masyarakat, tinjau aktivitas pengumpulan data, dan lakukan pembersihan data bermasalah.</p>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white/80 backdrop-blur-lg border border-slate-200 shadow-xl rounded-3xl overflow-hidden transition-all duration-300" x-data="{ openDeleteModal: false, deleteUrl: '' }">
        
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
            <h3 class="font-bold text-base text-[#1a365d] flex items-center space-x-2">
                <i class="fa-solid fa-list-ul text-[#4a7a8a]"></i>
                <span>Tabel Anggota & Hak Akses</span>
            </h3>
            <span class="text-xs text-slate-500">Total Pengguna: <strong class="text-slate-800">{{ $users->count() }}</strong></span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Alamat Email</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal Bergabung</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Catatan Log</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Tindakan Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($users as $index => $userItem)
                        <tr class="hover:bg-slate-50 transition-all duration-200">
                            <!-- No -->
                            <td class="px-6 py-4 text-sm text-slate-500 font-medium">{{ $index + 1 }}</td>
                            
                            <!-- Name & Role Badge -->
                            <td class="px-6 py-4 text-sm font-semibold">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-[#edf3f6] border border-slate-200 flex items-center justify-center font-bold text-xs text-[#4a7a8a]">
                                        {{ strtoupper(substr($userItem->name, 0, 2)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-slate-800">{{ $userItem->name }}</span>
                                        <span class="text-[10px] text-slate-500 mt-0.5 capitalize">
                                            @if($userItem->role === 'admin')
                                                <span class="text-[#4a7a8a] font-bold bg-[#5c8d9d]/10 px-1.5 py-0.5 rounded">Admin</span>
                                            @else
                                                <span class="text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded">Masyarakat</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Email -->
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $userItem->email }}
                            </td>
                            
                            <!-- Joined Date -->
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ \Carbon\Carbon::parse($userItem->created_at)->translatedFormat('d F Y') }}
                            </td>
                            
                            <!-- Total Submitted Logs -->
                            <td class="px-6 py-4 text-sm font-bold text-center sm:text-left">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $userItem->perjalanans_count > 0 ? 'bg-[#5c8d9d]/10 text-[#4a7a8a]' : 'bg-slate-100 text-slate-400' }}">
                                    {{ $userItem->perjalanans_count }} Log
                                </span>
                            </td>
                            
                            <!-- Administrative Action -->
                            <td class="px-6 py-4 text-sm text-center">
                                @if($userItem->id !== Auth::id())
                                    <button type="button" 
                                            @click="deleteUrl = '{{ route('admin.users.destroy', $userItem->id) }}'; openDeleteModal = true"
                                            class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-600 rounded-lg hover:-translate-y-0.5 transition-all duration-300 cursor-pointer text-xs font-bold"
                                            title="Hapus Akun Pengguna">
                                        <i class="fa-solid fa-user-minus mr-1"></i>Hapus Akun
                                    </button>
                                @else
                                    <span class="text-xs text-slate-400 italic">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <p class="font-medium text-base text-slate-600">Tidak ada pengguna terdaftar</p>
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
                          <h3 class="text-lg font-bold text-slate-800">Hapus Akun Pengguna</h3>
                          <p class="text-sm text-slate-500 mt-1 body-font">Apakah Anda yakin ingin menghapus akun pengguna ini? Seluruh catatan perjalanan terkait pengguna ini juga akan ikut terhapus secara permanen dari basis data.</p>
                      </div>
                  </div>
                  
                  <div class="mt-6 flex justify-end space-x-3 body-font">
                      <button type="button" 
                              @click="openDeleteModal = false" 
                              class="px-4 py-2 rounded-full bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold transition-all duration-300 cursor-pointer">
                          Batal
                      </button>
                      <form :action="deleteUrl" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" 
                                  class="px-4 py-2 rounded-full bg-rose-500 hover:bg-rose-600 text-white font-bold transition-all duration-300 hover:shadow-lg cursor-pointer">
                              Hapus Permanen
                          </button>
                      </form>
                  </div>
             </div>
        </div>

    </div>
</div>
@endsection
