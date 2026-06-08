@extends('layouts.app')

@section('content')
{{-- WRAPPER UTAMA: Menggunakan font modern minimalis sans-serif --}}
<div class="bg-gray-50 min-h-screen pt-20 font-sans antialiased">

    {{-- HERO BANNER --}}
    <section class="relative h-[260px] flex items-center justify-center text-center overflow-hidden">
        <img src="{{ asset('image/cowobelajar.jpg') }}" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-[#175BAF]/80"></div>
        <div class="relative z-10 text-white px-4">
            <h1 class="text-3xl font-bold tracking-tight mb-2">
                Konfirmasi Booking
            </h1>
            <p class="text-sm md:text-base opacity-90 font-light max-w-md mx-auto leading-relaxed">
                Satu langkah lagi untuk memulai sesi belajarmu bersama <b class="font-semibold">{{ $schedule->mentor->user->nama }}</b>
            </p>
        </div>
    </section>

    {{-- CARD DETAIL CONTAINER --}}
    <div class="max-w-xl mx-auto -mt-16 mb-20 relative z-20 px-4">
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-8 border border-gray-100">

            {{-- SUCCESS STATE --}}
            @if(session('success'))
                <div class="text-center py-6">
                    <div class="w-16 h-16 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-5 border border-green-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">
                        Booking Berhasil!
                    </h2>
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed max-w-xs mx-auto">
                        Jadwal kamu sudah tercatat di sistem. Mentor akan segera menghubungimu melalui detail kontak.
                    </p>

                    <div class="mt-8 flex flex-col gap-2.5">
                        <a href="{{ route('profile.index') }}" class="bg-[#175BAF] text-white text-xs font-semibold px-6 py-3 rounded-xl hover:bg-blue-700 transition shadow-sm">
                            Lihat Profil & Jadwal
                        </a>
                        <a href="{{ route('courses.index') }}" class="text-xs text-slate-400 hover:text-[#175BAF] font-medium transition py-2">
                            ← Kembali ke Daftar Mentor
                        </a>
                    </div>
                </div>

            {{-- FORM & DETAIL STATE --}}
            @else
                <div>
                    <div class="mb-5">
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center text-[11px] font-bold uppercase tracking-wider text-slate-400 hover:text-[#175BAF] transition gap-1 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali ke Daftar Mentor
                        </a>
                    </div>

                    <h2 class="text-xl font-bold text-[#175BAF] tracking-tight mb-6 border-b border-slate-100 pb-3">
                        Detail Booking
                    </h2>

                    {{-- GRID DETAIL DATA --}}
                    <div class="space-y-4 text-slate-700">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Mentor</label>
                            <span class="font-semibold text-sm text-slate-800 mt-0.5 block">
                                {{ $schedule->mentor->user->nama }}
                            </span>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Spesialisasi</label>
                            <span class="font-semibold text-sm text-slate-800 mt-0.5 block">
                                {{ $schedule->mentor->spesialisasi }}
                            </span>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Tanggal Sesi</label>
                            <span class="font-semibold text-sm text-slate-800 mt-0.5 block">
                                {{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}
                            </span>
                        </div>

                        {{-- PERUBAHAN DI SINI: Menampilkan jam mulai s.d. jam selesai --}}
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Waktu / Jam Sesi</label>
                            <span class="font-semibold text-sm text-slate-800 mt-0.5 block flex items-center gap-1.5">
                                {{ \Carbon\Carbon::parse($schedule->jam)->format('H:i') }} 
                                <span class="text-slate-300 font-normal">s.d.</span> 
                                {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }} 
                                <span class="text-xs text-slate-400 font-medium bg-slate-50 border border-slate-100 px-1.5 py-0.5 rounded">WIB</span>
                            </span>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Total Investasi</label>
                            <span class="font-bold text-base text-[#175BAF] mt-0.5 block">
                                Rp {{ number_format($schedule->harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- ALERTS SYSTEM --}}
                    @if(session('already'))
                        <div class="mt-6 bg-amber-50 text-amber-700 border border-amber-100 p-3 rounded-xl text-xs font-medium">
                            ⚠️ Kamu sudah pernah melakukan booking untuk sesi jadwal ini.
                        </div>
                    @endif

                    @if(session('unavailable'))
                        <div class="mt-6 bg-rose-50 text-rose-700 border border-rose-100 p-3 rounded-xl text-xs font-medium">
                            🛑 Maaf, jadwal ini sudah tidak tersedia atau telah diambil user lain.
                        </div>
                    @endif

                    {{-- CONDITIONAL ACTION BUTTONS --}}
                    <div class="mt-8">
                        @if($isOwnMentor)
                            <button disabled class="w-full bg-slate-200 text-slate-400 text-xs font-semibold py-3.5 rounded-xl cursor-not-allowed">
                                Ini Jadwal Kelas Milik Anda
                            </button>
                        @elseif($isAlreadyBooked)
                            <button disabled class="w-full bg-slate-200 text-slate-400 text-xs font-semibold py-3.5 rounded-xl cursor-not-allowed">
                                Sesi Sudah Dibooking
                            </button>
                        @elseif($schedule->status == 'available')
                            <form action="{{ route('booking.store', $schedule->id_schedule) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-[#175BAF] text-white text-xs font-semibold py-3.5 rounded-xl hover:bg-blue-700 transition shadow-sm">
                                    Konfirmasi & Book Sekarang
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-slate-200 text-slate-400 text-xs font-semibold py-3.5 rounded-xl cursor-not-allowed">
                                Tidak Tersedia
                            </button>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection