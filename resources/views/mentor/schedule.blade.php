@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen pt-24 pb-12 antialiased">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-xs font-semibold shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 mb-8 border-b border-gray-200/60 gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">
                    My Schedule
                </h1>
                <p class="text-xs text-gray-500 mt-1 font-normal">
                    Kelola dan pantau seluruh jadwal mentoring aktif kamu di MentorKampus.
                </p>
            </div>
            
            <div class="shrink-0">
                <a href="{{ route('mentor.schedule.create') }}"
                   class="inline-flex items-center justify-center bg-[#175BAF] text-white px-5 py-2.5 rounded-xl text-xs font-semibold shadow hover:bg-blue-700 transition-all cursor-pointer gap-2">
                    <svg xmlns="http://www.w3.org/2000/xl" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Jadwal
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
            @forelse($schedules as $schedule)
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 flex flex-col justify-between shadow-sm transition-all duration-200 hover:shadow-md hover:border-gray-300">
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                Aktif
                            </span>
                            <p class="text-[#175BAF] font-bold text-base tracking-tight">
                                Rp {{ number_format($schedule->harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="space-y-2 bg-gray-50 rounded-xl p-3 border border-gray-100">
                            <div class="flex items-center gap-2.5 text-xs text-gray-600 font-normal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}</span>
                            </div>

                            <div class="flex items-center gap-2.5 text-xs text-gray-600 font-normal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($schedule->jam)->format('H:i') }} WIB</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-gray-100 w-full">
                        <form action="{{ route('mentor.schedule.delete', $schedule->id_schedule) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus jadwal ini?');" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-50 text-red-600 border border-red-100 py-2.5 rounded-xl text-xs font-semibold text-center hover:bg-red-100 hover:text-red-700 transition shadow-sm cursor-pointer block">
                                Hapus Jadwal Mentoring
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-gray-200/80 p-16 text-center text-gray-400 shadow-sm flex flex-col items-center justify-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Kamu belum membuat jadwal mentoring</p>
                    <p class="text-xs text-gray-400 max-w-sm">Klik tombol tambah jadwal di atas untuk mengatur ketersediaan waktu luang mengajarmu.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection