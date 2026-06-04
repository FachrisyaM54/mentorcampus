@extends('layouts.app')

@section('content')

<div class="pt-24 max-w-5xl mx-auto">

    <div class="bg-white rounded-2xl shadow p-8">

        <h1 class="text-3xl font-bold">
            {{ $mentor->user->nama }}
        </h1>

        <p class="text-gray-500">
            {{ $mentor->kampus->nama_kampus }}
        </p>

        @if($avgRating > 0)

        <div class="mt-3 flex items-center gap-2">

            <span class="text-yellow-500 text-lg font-semibold">
                ⭐ {{ $avgRating }}
            </span>

            <span class="text-gray-500">
                ({{ $totalReview }} review)
            </span>

        </div>

        @else

        <p class="text-gray-400 mt-2">
            Belum ada rating
        </p>

        @endif

        <hr class="my-6">

        <div class="space-y-3">

            <p>
                <strong>Fakultas:</strong>
                {{ $mentor->fakultas }}
            </p>

            <p>
                <strong>Jurusan:</strong>
                {{ $mentor->jurusan }}
            </p>

            <p>
                <strong>Spesialisasi:</strong>
                {{ $mentor->spesialisasi }}
            </p>

            <p>
                <strong>Biografi:</strong>
                {{ $mentor->biografi }}
            </p>

            <p>
                <strong>Pengalaman:</strong>
                {{ $mentor->pengalaman ?? '-' }}
            </p>

        </div>

    </div>

    <div class="bg-white rounded-2xl shadow p-8 mt-6">

        <h2 class="text-xl font-bold mb-4">
            Jadwal Tersedia
        </h2>

        @forelse($schedules as $schedule)

            <div class="border rounded-lg p-4 mb-3">

                <div class="flex justify-between">

                    <div>

                        <p>
                            {{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}
                        </p>

                        <p>
                            {{ \Carbon\Carbon::parse($schedule->jam)->format('H:i') }}
                        </p>

                    </div>

                    <div>

                        Rp {{ number_format($schedule->harga) }}

                    </div>

                </div>

            </div>

        @empty

            <p>
                Belum ada jadwal tersedia.
            </p>

        @endforelse

    </div>

    <div class="bg-white rounded-2xl shadow p-8 mt-6">

    <h2 class="text-xl font-bold mb-4">
        Review Mentor
    </h2>

    @forelse($reviews as $review)

        <div class="border-b py-4">

            <div class="flex items-center justify-between">

                <strong>
                    {{ $review->booking->student->nama ?? 'Student' }}
                </strong>

                <span class="text-yellow-500">
                    ⭐ {{ $review->rating }}/5
                </span>

            </div>

            <p class="text-gray-600 mt-2">
                {{ $review->komentar ?: 'Tidak ada komentar.' }}
            </p>

        </div>

    @empty

        <p class="text-gray-500">
            Belum ada review untuk mentor ini.
        </p>

    @endforelse

</div>

</div>

@endsection