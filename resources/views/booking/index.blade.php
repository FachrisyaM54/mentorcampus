@extends('layouts.app')

@section('content')

<body class="bg-gray-50 pt-20">

<section class="relative h-[300px] flex items-center justify-center text-center overflow-hidden">

    <img src="{{ asset('image/cowobelajar.jpg') }}"
         class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 bg-[#175BAF]/80"></div>

    <div class="relative z-10 text-white px-4">
        <h1 class="text-4xl font-bold mb-2">
            Konfirmasi Booking
        </h1>

        <p class="text-lg opacity-90">
            Satu langkah lagi untuk memulai sesi belajarmu bersama
            <b>{{ $schedule->mentor->user->nama }}</b>
        </p>
    </div>

</section>

<div class="max-w-2xl mx-auto -mt-12 mb-20 relative z-20 px-4">

    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">

        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="text-center py-10">

                <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-10 w-10"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="3"
                              d="M5 13l4 4L19 7" />

                    </svg>

                </div>

                <h2 class="text-2xl font-bold text-gray-800">
                    🎉 Booking Berhasil!
                </h2>

                <p class="text-gray-500 mt-3 leading-relaxed">
                    Jadwal kamu sudah tercatat.
                    Mentor akan segera menghubungimu.
                </p>

                <div class="mt-8 flex flex-col gap-3">

                    <a href="{{ route('profile.index') }}"
                       class="bg-[#175BAF] text-white font-semibold px-8 py-3 rounded-xl hover:bg-blue-700 transition">

                        Lihat Profil

                    </a>

                    <a href="{{ route('courses.index') }}"
                       class="text-gray-400 hover:text-[#175BAF] font-medium transition py-2">

                        ← Kembali ke Daftar Mentor

                    </a>

                </div>

            </div>

        @else

            {{-- DETAIL BOOKING --}}
            <div>
                <div class="py-2">
                    <a href="{{ route('courses.index') }}"
                       class="text-gray-400 hover:text-[#175BAF] font-medium transition py-2">

                        ← Kembali ke Daftar Mentor

                    </a>
                </div>
                <h2 class="text-2xl font-bold text-[#175BAF] mb-6">
                    Detail Booking
                </h2>

                <div class="space-y-4">

                    <div>
                        <p class="text-sm text-gray-400">Mentor</p>
                        <p class="font-semibold">
                            {{ $schedule->mentor->user->nama }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Spesialisasi</p>
                        <p class="font-semibold">
                            {{ $schedule->mentor->spesialisasi }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Tanggal</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Jam</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($schedule->jam)->format('H:i') }} WIB
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Harga</p>
                        <p class="font-semibold text-[#175BAF] pb-5">
                            Rp {{ number_format($schedule->harga, 0, ',', '.') }}
                        </p>
                    </div>

                </div>

                {{-- ALERT --}}
                @if(session('already'))

                    <div class="mt-6 bg-yellow-100 text-yellow-700 p-4 rounded-xl">
                        Kamu sudah pernah booking jadwal ini.
                    </div>

                @endif

                @if(session('unavailable'))

                    <div class="mt-6 bg-red-100 text-red-700 p-4 rounded-xl">
                        Jadwal sudah tidak tersedia.
                    </div>

                @endif

                {{-- BUTTON --}}
                @if(!$isAlreadyBooked && $schedule->status == 'available')

                    @if($isOwnMentor)

                        <button disabled type="submit" class="w-full bg-gray-400 text-white py-3 rounded-xl cursor-not-allowed transition">
                            Ini Jadwal Milik Anda
                        </button>

                    @elseif($isAlreadyBooked)

                        <button disabled class="w-full bg-gray-400 text-white py-3 rounded-xl">
                            Sudah Dibooking
                        </button>

                    @else

                        {{-- tombol booking normal --}}

                        <button type="submit" class="w-full bg-[#175BAF] text-white py-3 rounded-xl hover:bg-blue-700 transition">
                        Book Sekarang </button>

                    @endif

                @endif

            </div>

        @endif

    </div>

</div>

@endsection