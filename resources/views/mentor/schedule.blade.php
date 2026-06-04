@extends('layouts.app')

@section('content')
<div class="pt-5">
    <div class="pt-24 max-w-6xl mx-auto">

    <div class="mb-6">

        <a href="{{ route('mentor.schedule.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            + Tambah Jadwal
        </a>

    </div>

        <h1 class="text-3xl font-bold mb-6">
            My Schedule
        </h1>

        @foreach($schedules as $schedule)

            <div class="bg-white p-4 rounded-lg shadow mb-3">

                <strong>
                    {{ $schedule->tanggal }}
                </strong>

                -

                {{ $schedule->jam }}

                -

                Rp{{ number_format($schedule->harga) }}

            </div>

        @endforeach

    </div>

</div>

@endsection