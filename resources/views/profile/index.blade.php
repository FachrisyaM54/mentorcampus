@extends('layouts.app')
@section('content')
<div class="pt-20">
        <div class="max-w-7xl mx-auto py-10">

        <div class="grid md:grid-cols-3 gap-6">

            <div>

                {{-- Profile Card --}}
                <div class="bg-white rounded-2xl shadow p-6 text-center">

                    @if($user->foto_profil)
                        <img src="{{ asset($user->foto_profil) }}"
                            class="w-24 h-24 mx-auto rounded-full object-cover">
                    @else
                        <div class="w-24 h-24 mx-auto rounded-full bg-blue-100 flex items-center justify-center text-3xl font-bold text-blue-600">
                            {{ strtoupper(substr($user->nama,0,1)) }}
                        </div>
                    @endif

                    <h2 class="mt-4 text-xl font-bold">
                        {{ $user->nama }}
                    </h2>

                    <p class="text-gray-500">
                        {{ $user->email }}
                    </p>

                </div>

                {{-- Statistik --}}
                <div class="space-y-4 mt-4">

                    <div class="bg-white rounded-2xl shadow p-5">
                        <p class="text-sm text-gray-500">Total Sessions</p>
                        <h3 class="text-3xl font-bold text-blue-600">
                            {{ $total }}
                        </h3>
                    </div>

                    <div class="bg-white rounded-2xl shadow p-5">
                        <p class="text-sm text-gray-500">Completed</p>
                        <h3 class="text-3xl font-bold text-green-600">
                            {{ $completed }}
                        </h3>
                    </div>

                    <div class="bg-white rounded-2xl shadow p-5">
                        <p class="text-sm text-gray-500">Ongoing</p>
                        <h3 class="text-3xl font-bold text-yellow-500">
                            {{ $ongoing }}
                        </h3>
                    </div>

                </div>

            </div>

            <div class="md:col-span-2">

                <div class="bg-white rounded-2xl shadow p-6">

                    <h2 class="text-xl font-bold mb-5">
                        Ongoing Sessions
                    </h2>

                    @forelse($ongoingBookings as $booking)

                        <div class="border rounded-xl p-4 mb-4">

                            <div class="flex justify-between">

                                <div>

                                    <h3 class="font-bold">
                                        {{ $booking->schedule?->mentor?->user?->nama ?? 'Mentor tidak ditemukan' }}
                                    </h3>

                                    <p class="text-gray-500 text-sm">
                                        {{ $booking->schedule?->mentor?->kampus?->nama_kampus ?? '-' }}
                                    </p>

                                    <p class="text-sm mt-2">
                                        {{ \Carbon\Carbon::parse($booking->schedule->tanggal)->format('d M Y') }}
                                    </p>

                                    <p class="text-sm">
                                        {{ \Carbon\Carbon::parse($booking->schedule->jam)->format('H:i') }}
                                    </p>
                                    
                                    <div class="flex gap-2 mt-4">

                                        <form method="POST"
                                            action="{{ route('booking.finish', $booking->id_booking) }}">
                                            @csrf

                                            <button type="submit"
                                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-xs font-bold">
                                                Selesai
                                            </button>
                                        </form>

                                        <form method="POST"
                                            action="{{ route('booking.cancel', $booking->id_booking) }}"
                                            onsubmit="return confirm('Yakin mau batalkan sesi ini?')">

                                            @csrf

                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-xs font-bold">
                                                Batalkan
                                            </button>
                                        </form>

                                    </div>
                                </div>

                                <div>

                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">
                                        Ongoing
                                    </span>

                                </div>

                            </div>

                        </div>

                    @empty

                        <p class="text-gray-500">
                            Belum ada sesi berjalan.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>
@endsection