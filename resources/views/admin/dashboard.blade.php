@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="pt-24 max-w-7xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">
        Admin Dashboard
    </h1>

    <div class="mb-6">

    <a
        href="{{ route('admin.report.pdf') }}"
        class="bg-red-600 text-white px-4 py-2 rounded-lg"
    >
        Export PDF Report
    </a>

</div>

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

    <div class="grid md:grid-cols-2 gap-6 mt-8">

    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="font-bold mb-4">
            Distribusi User
        </h2>

        <canvas id="userChart"></canvas>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="font-bold mb-4">
            Status Booking
        </h2>

        <canvas id="statusChart"></canvas>
    </div>

</div>

<div class="bg-white p-6 rounded-xl shadow mt-8">

    <h2 class="font-bold mb-4">
        Booking per Bulan
    </h2>

    <canvas id="bookingChart"></canvas>

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
<script>

const userChart = new Chart(
    document.getElementById('userChart'),
    {
        type: 'pie',
        data: {
            labels: [
                'Student',
                'Mentor',
                'Admin'
            ],
            datasets: [{
                data: [
                    {{ $studentCount }},
                    {{ $mentorCount }},
                    {{ $adminCount }}
                ]
            }]
        }
    }
);

const statusChart = new Chart(
    document.getElementById('statusChart'),
    {
        type: 'doughnut',
        data: {
            labels: [
                'Completed',
                'Ongoing',
                'Cancelled'
            ],
            datasets: [{
                data: [
                    {{ $completedBooking }},
                    {{ $ongoingBooking }},
                    {{ $cancelledBooking }}
                ]
            }]
        }
    }
);

const bookingChart = new Chart(
    document.getElementById('bookingChart'),
    {
        type: 'bar',
        data: {
            labels: [
                @foreach($bookingPerMonth as $item)
                    'Bulan {{ $item->month }}',
                @endforeach
            ],
            datasets: [{
                label: 'Jumlah Booking',
                data: [
                    @foreach($bookingPerMonth as $item)
                        {{ $item->total }},
                    @endforeach
                ]
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    }
);

</script>
@endsection