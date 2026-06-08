@extends('layouts.app')

@section('content')

<div class="pt-24 max-w-5xl mx-auto px-4 pb-12">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">
                Session History & Reviews
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Berikut adalah riwayat ulasan dan rating yang diberikan oleh student secara anonim.
            </p>
        </div>

        <div class="space-y-4">
            @forelse($histories as $booking)
                {{-- Kita hanya menampilkan jika statusnya completed dan student memberikan rating --}}
                @if($booking->status == 'completed')
                    <div class="border border-gray-100 bg-gray-50/50 rounded-2xl p-5 transition hover:shadow-md">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                            <div class="flex items-center gap-3">
                                {{-- Identitas Anonim --}}
                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-semibold text-gray-600">
                                    S
                                </div>
                                <div>
                                    <h3 class="font-semibold text-sm text-gray-700">
                                        Student (Anonim)
                                    </h3>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        Sesi pada: {{ \Carbon\Carbon::parse($booking->schedule?->tanggal)->format('d M Y') }} &bull; {{ \Carbon\Carbon::parse($booking->schedule?->jam)->format('H:i') }} WIB
                                    </p>
                                </div>
                            </div>

                            {{-- Render Bintang Berdasarkan Angka Rating --}}
                            <div class="flex items-center gap-1">
                                @if($booking->rating)
                                    <div class="flex text-amber-400 text-sm">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $booking->rating)
                                                ⭐
                                            @else
                                                <span class="text-gray-300">⭐</span>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md ml-1">
                                        {{ number_format($booking->rating, 1) }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 italic">Sesi selesai (Belum memberi rating)</span>
                                @endif
                            </div>
                        </div>

                        {{-- Bagian Isi Ulasan/Comment --}}
                        <div class="bg-white rounded-xl p-3.5 border border-gray-100 text-sm text-gray-600 italic">
                            @if(!empty($booking->comment))
                                "{{ $booking->comment }}"
                            @else
                                <span class="text-gray-400">"Student tidak meninggalkan pesan tertulis."</span>
                            @endif
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center py-12 border border-dashed border-gray-200 rounded-2xl bg-gray-50/30 flex flex-col items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-gray-500 text-sm font-medium">
                        Belum ada riwayat ulasan dari student.
                    </p>
                </div>
            @endforelse
        </div>

    </div>

</div>

@endsection