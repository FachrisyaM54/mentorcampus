@extends('layouts.admin')
@section('content')

<div class="pt-24 pb-12 w-full px-0 bg-gray-50 min-h-screen flex flex-col items-center">
    
    <div class="relative overflow-hidden w-full border-b border-gray-200/50">
        <div class="absolute inset-0 bg-gradient-to-r from-gray-950/85 via-gray-950/50 to-transparent z-10"></div>
        <img src="{{ asset('image/wanita-belajar.jpg') }}" alt="Mentor Campus" class="w-full h-48 md:h-56 object-cover object-center">
        <div class="absolute inset-0 flex flex-col justify-center px-4 md:px-8 z-20">
            <span class="text-[10px] font-semibold text-indigo-400 uppercase tracking-widest bg-indigo-950/60 px-2 py-0.5 w-max border border-indigo-900/30 mb-2">Management Panel</span>
            <h1 class="text-xl md:text-2xl font-medium text-white tracking-tight">Mentor Management</h1>
            <p class="text-xs text-gray-300 mt-1 max-w-2xl font-normal leading-relaxed">Pantau spesialisasi, asal instansi, dan kelola hak akses seluruh mentor yang aktif di dalam sistem.</p>
        </div>
    </div>

    <div class="w-full px-4 md:px-8 mt-8">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 pb-4 border-b border-gray-200/60 gap-4 w-full">
            <div>
                <h2 class="text-xs font-semibold text-gray-500 tracking-wider uppercase">Daftar Mentor Aktif</h2>
                <p class="text-xs text-gray-400 mt-0.5">Total pengajar saat ini: <span class="font-medium text-indigo-600">{{ $mentors->count() }} Orang</span></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 w-full">
            @forelse($mentors as $mentor)
                <div class="bg-white border border-gray-200 shadow-sm overflow-hidden flex flex-col justify-between transition-all duration-200 hover:shadow">
                    
                    <div class="p-5">
                        <div class="flex items-center gap-4">
                            {{-- 💡 PERBAIKAN: Validasi keberadaan foto profil dan pengecekan default image secara presisi --}}
                            @if(!empty($mentor->user?->foto_profil) && $mentor->user->foto_profil != 'default.jpg')
                                <img src="{{ asset('storage/' . ltrim($mentor->user->foto_profil, '/')) }}?t={{ time() }}" class="w-12 h-12 object-cover border border-gray-100">
                            @else
                                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 flex items-center justify-center font-semibold text-sm border border-indigo-100/50 shrink-0">
                                    {{ strtoupper(substr($mentor->user->nama ?? 'M', 0, 1)) }}
                                </div>
                            @endif
                            
                            <div class="overflow-hidden">
                                <h3 class="font-semibold text-gray-800 text-sm tracking-wide truncate">
                                    {{ $mentor->user->nama ?? 'Mentor' }}
                                </h3>
                                <p class="text-xs text-gray-400 font-normal truncate mt-0.5">{{ $mentor->user->email ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="my-4 border-t border-gray-100"></div>

                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between items-start gap-4">
                                <span class="text-gray-400 font-normal shrink-0">Spesialisasi</span>
                                <span class="px-2 py-0.5 bg-indigo-50/70 text-indigo-700 font-medium text-[10px] border border-indigo-100/30 truncate max-w-[160px]">
                                    {{ $mentor->spesialisasi ?? '-' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 font-normal">Jurusan</span>
                                <span class="font-normal text-gray-600 max-w-[180px] truncate text-right">{{ $mentor->jurusan ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 font-normal">Kampus</span>
                                <span class="font-medium text-gray-700 max-w-[180px] truncate text-right">{{ $mentor->kampus?->nama_kampus ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-5 py-3 bg-gray-50/60 border-t border-gray-100 flex items-center justify-between gap-2">
                        <a href="{{ route('admin.mentors.detail', $mentor->id_mentor) }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-500 hover:text-indigo-600 transition">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Detail Profil
                        </a>

                        <form action="{{ route('admin.mentors.delete', $mentor->id_mentor) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-medium text-gray-400 hover:text-red-600 transition px-2 py-1 hover:bg-red-50 cursor-pointer" onclick="return confirm('Hapus mentor ini?')">
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="col-span-full bg-white border border-gray-200 p-16 text-center text-gray-400 shadow-sm">
                    <div class="flex flex-col items-center justify-center gap-2">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span class="text-xs font-normal text-gray-400">Belum ada mentor resmi yang terdaftar aktif.</span>
                    </div>
                </div>
            @endforelse
        </div>
        
    </div>

</div>

@endsection