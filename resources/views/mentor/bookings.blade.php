@extends('layouts.app')
@section('content')

<div class="pt-24 max-w-6xl mx-auto">

    <div class="bg-white rounded-2xl shadow p-6">

        <h1 class="text-2xl font-bold mb-6">
            Student Bookings
        </h1>

        @forelse($bookings as $booking)

            <div class="border rounded-xl p-4 mb-4">

                <div class="flex justify-between">

                    <div>

                        <h3 class="font-bold">
                            {{ $booking->student?->nama }}
                        </h3>

                        <p class="text-gray-500">
                            {{ $booking->student?->email }}
                        </p>

                        <p class="text-sm mt-2">
                            {{ $booking->schedule->tanggal }}
                        </p>

                        <p class="text-sm">
                            {{ $booking->schedule->jam }}
                        </p>

                    </div>

                    <div>

                        @if($booking->status == 'ongoing')

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                Ongoing
                            </span>

                        @elseif($booking->status == 'completed')

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                Completed
                            </span>

                        @else

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                Cancelled
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <p>
                Belum ada booking.
            </p>

        @endforelse

    </div>

</div>

@endsection