@if(session('success'))

<div class="mb-6 bg-green-100 text-green-700 px-4 py-3 rounded-xl">
    {{ session('success') }}
</div>

@endif
@extends('layouts.app')
@section('content')
<div class="pt-20">
        <div class="max-w-7xl mx-auto py-10">

        <div class="grid md:grid-cols-3 gap-6">

            <div>

                {{-- Profile Card --}}
                <div class="bg-white rounded-2xl shadow p-6 text-center">

                    @if($user->foto_profil)
                    <img
                        src="{{ asset('storage/'.$user->foto_profil) }}"
                        class="w-24 h-24 mx-auto rounded-full object-cover">
                    @else
                        <div class="w-24 h-24 mx-auto rounded-full bg-blue-100 flex items-center justify-center text-3xl font-bold text-blue-600">
                            {{ strtoupper(substr($user->nama,0,1)) }}
                        </div>
                    @endif

                    <h2 class="mt-4 text-xl font-bold">
                        <form
                            action="{{ route('profile.update') }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="space-y-4 mt-4">

                            @csrf

                            <input
                                type="text"
                                name="nama"
                                value="{{ $user->nama }}"
                                class="w-full border rounded-lg px-3 py-2">

                            <input
                                type="file"
                                name="foto_profil"
                                class="w-full text-sm">

                            <button
                                class="w-full bg-blue-600 text-white py-2 rounded-lg">
                                Simpan Perubahan
                            </button>

                        </form>
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

                    <div class="bg-white rounded-2xl shadow p-6 mt-6">

                        <h2 class="text-xl font-bold mb-5">
                            Completed Sessions
                        </h2>

                        @forelse($completedBookings as $booking)

                            <div class="border rounded-xl p-4 mb-3">

                                <div class="flex justify-between items-center">

                                    <div>
                                        <h3 class="font-bold">
                                            {{ $booking->schedule?->mentor?->user?->nama }}
                                        </h3>

                                        <p class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($booking->schedule->tanggal)->format('d M Y') }}
                                            •
                                            {{ \Carbon\Carbon::parse($booking->schedule->jam)->format('H:i') }}
                                        </p>

                                        <span class="text-green-600 text-sm">
                                            Completed
                                        </span>
                                    </div>

                                    <div>
                                        @if($booking->review)

                                            <a href="{{ route('rating.create', $booking->id_booking) }}"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-xs font-bold">
                                                Update Rating
                                            </a>

                                        @else

                                            <a href="{{ route('rating.create', $booking->id_booking) }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-bold">
                                                Beri Rating
                                            </a>

                                        @endif
                                    </div>

                                </div>

                            </div>

                        @empty

                            <p class="text-gray-500">
                                Belum ada sesi selesai.
                            </p>

                        @endforelse

                    </div>
                    
                    <div class="bg-white rounded-2xl shadow p-6 mt-6">

                        <h2 class="text-xl font-bold mb-5">
                            Cancelled Sessions
                        </h2>

                        @forelse($cancelledBookings as $booking)

                            <div class="border rounded-xl p-4 mb-3">
                                <h3 class="font-bold">
                                    {{ $booking->schedule?->mentor?->user?->nama }}
                                </h3>

                                <span class="text-red-600 text-sm">
                                    Cancelled
                                </span>
                            </div>

                        @empty

                            <p class="text-gray-500">
                                Belum ada sesi dibatalkan.
                            </p>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection