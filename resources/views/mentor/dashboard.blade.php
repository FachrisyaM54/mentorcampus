@extends('layouts.app')

@section('content')

<div class="pt-24 max-w-7xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">
        Mentor Dashboard
    </h1>

    <div class="grid md:grid-cols-4 gap-4 mb-8">

        <div class="bg-white p-5 rounded-xl shadow">
            <p>Total Booking</p>
            <h2 class="text-3xl font-bold">
                {{ $totalBooking }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p>Completed</p>
            <h2 class="text-3xl font-bold text-green-600">
                {{ $completedBooking }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p>Ongoing</p>
            <h2 class="text-3xl font-bold text-yellow-600">
                {{ $ongoingBooking }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p>Total Schedule</p>
            <h2 class="text-3xl font-bold text-blue-600">
                {{ $totalSchedule }}
            </h2>
        </div>

    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <h2 class="font-bold text-xl mb-4">
            Recent Booking
        </h2>

        @forelse($recentBookings as $booking)

            <div class="border-b py-3">

                <p class="font-semibold">
                    {{ $booking->student?->nama }}
                </p>

                <p class="text-sm text-gray-500">
                    {{ $booking->status }}
                </p>

            </div>

        @empty

            <p>
                Belum ada booking.
            </p>

        @endforelse

    </div>

</div>

@endsection