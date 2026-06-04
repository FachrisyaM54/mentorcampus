@extends('layouts.admin')

@section('content')

<div class="pt-24 max-w-7xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">
        Admin Dashboard
    </h1>

    <div class="grid md:grid-cols-4 gap-5">

        <div class="bg-white p-6 rounded-xl shadow">
            <p>Total User</p>
            <h2 class="text-3xl font-bold">
                {{ $totalUser }}
            </h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p>Total Mentor</p>
            <h2 class="text-3xl font-bold">
                {{ $totalMentor }}
            </h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p>Total Booking</p>
            <h2 class="text-3xl font-bold">
                {{ $totalBooking }}
            </h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p>Pending Mentor</p>
            <h2 class="text-3xl font-bold text-yellow-500">
                {{ $pendingMentor }}
            </h2>
        </div>

    </div>

    <div class="bg-white rounded-xl shadow p-6 mt-8">

        <h2 class="text-xl font-bold mb-4">
            Latest Booking
        </h2>

        @forelse($latestBookings as $booking)

            <div class="border-b py-3">

                <p>
                    {{ $booking->student?->nama ?? '-' }}
                </p>

                <p class="text-sm text-gray-500">
                    {{ $booking->status }}
                </p>

            </div>

        @empty

            <p>Tidak ada data.</p>

        @endforelse

    </div>

</div>

@endsection