@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen pt-20">

    {{-- HERO BANNER VARIASI: WANITA BELAJAR DITIMPA WARNA BIRU --}}
    <section class="relative h-[260px] flex items-center justify-center text-center overflow-hidden">
        <img src="{{ asset('image/wanita-belajar.jpg') }}" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-[#175BAF]/80"></div>
        <div class="relative z-10 text-white px-4">
            <h1 class="text-4xl font-bold mb-2 tracking-tight">
                Daftar Sesi Mentoring
            </h1>
            <p class="text-lg opacity-90 font-light">
                Pantau jadwal bimbingan aktif dan koordinasikan ruang belajar Anda.
            </p>
        </div>
    </section>

    {{-- CONTAINER UTAMA --}}
    <div class="max-w-6xl mx-auto -mt-12 mb-20 relative z-20 px-4">
        <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
            
            <h1 class="text-2xl font-bold mb-6 text-gray-800">
                Student Bookings
            </h1>

            {{-- STRUKTUR TABEL MODERN MINIMALIS --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-sm text-gray-400">
                            <th class="pb-4 font-semibold">Student</th>
                            <th class="pb-4 font-semibold">Tanggal Kelas</th>
                            <th class="pb-4 font-semibold">Waktu / Jam</th>
                            <th class="pb-4 font-semibold text-center">Status</th>
                            <th class="pb-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50/50 transition">
                                
                                {{-- KOLOM 1: NAMA & EMAIL STUDENT --}}
                                <td class="py-5">
                                    <h3 class="font-bold text-gray-800">
                                        {{ $booking->student?->nama }}
                                    </h3>
                                    <p class="text-gray-500 text-sm">
                                        {{ $booking->student?->email }}
                                    </p>
                                </td>

                                {{-- KOLOM 2: TANGGAL --}}
                                <td class="py-5">
                                    <p class="text-sm text-gray-700 font-medium">
                                        {{ \Carbon\Carbon::parse($booking->schedule->tanggal)->format('d M Y') }}
                                    </p>
                                </td>

                                {{-- KOLOM 3: JAM MULAI DAN JAM SELESAI --}}
                                <td class="py-5">
                                    <p class="text-sm text-gray-700 font-semibold">
                                        {{ \Carbon\Carbon::parse($booking->schedule->jam)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->schedule->jam_selesai)->format('H:i') }} WIB
                                    </p>
                                </td>

                                {{-- KOLOM 4: STATUS SESI --}}
                                <td class="py-5 text-center">
                                    @if($booking->status == 'ongoing')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Ongoing
                                        </span>
                                    @elseif($booking->status == 'completed')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Completed
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Cancelled
                                        </span>
                                    @endif
                                </td>

                                {{-- KOLOM 5: INTERAKSI TOMBOL --}}
                                <td class="py-5 text-right">
                                    <div class="flex items-center justify-end gap-2.5">
                                        
                                        {{-- JIKA STATUS ONGOING, MUNCULKAN TOMBOL HUBUNGI & SELESAIKAN --}}
                                        @if($booking->status == 'ongoing')
                                            {{-- BUTTON HUBUNGI STUDENT (EXPLAINER FLOW) --}}
                                            <a href="https://wa.me/{{ $booking->student?->no_hp ?? '' }}" target="_blank" class="inline-flex items-center gap-1 bg-white border border-gray-200 text-gray-600 text-xs font-bold px-3 py-2 rounded-lg hover:border-[#175BAF] hover:text-[#175BAF] transition shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                </svg>
                                                Hubungi Student
                                            </a>

                                            {{-- ACTION BUTTON SELESAIKAN SESI --}}
                                            <form method="POST" action="{{ route('booking.finish', $booking->id_booking) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition" onclick="return confirm('Selesaikan sesi ini?')">
                                                    Selesaikan Sesi
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 font-medium italic pr-2">Sesi Selesai</span>
                                        @endif

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-gray-400 text-sm">
                                    Belum ada booking mahasiswa yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection