@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 flex items-center justify-center py-10">

    <div class="max-w-lg w-full bg-white p-8 rounded-3xl shadow-xl">

        <div class="text-center mb-6">

            <h2 class="text-2xl font-bold text-blue-600">
                ⭐ Rating Mentor
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Bagikan pengalaman belajarmu
            </p>

        </div>

        <form
            method="POST"
            action="{{ route('rating.store',$booking->id_booking) }}"
            class="space-y-5">

            @csrf

            <div>

                <label class="block text-sm mb-2 font-medium">
                    Rating
                </label>

                <select
                    name="rating"
                    class="w-full border px-4 py-2 rounded-lg">

                    @for($i=5;$i>=1;$i--)

                        <option
                            value="{{ $i }}"
                            @selected(optional($review)->rating == $i)>

                            {{ str_repeat('⭐',$i) }}
                            ({{ $i }})

                        </option>

                    @endfor

                </select>

            </div>

            <div>

                <label class="block text-sm mb-2 font-medium">
                    Komentar
                </label>

                <textarea
                    name="komentar"
                    rows="4"
                    class="w-full border px-4 py-2 rounded-lg"
                    placeholder="Ceritakan pengalamanmu">{{ $review->komentar ?? '' }}</textarea>

            </div>

            @if($review)

                <p class="text-green-600 text-sm">
                    Kamu sudah memberi rating.
                    Silakan update jika ingin mengubah.
                </p>

            @endif

            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium">

                {{ $review ? 'Update Rating' : 'Kirim Rating' }}

            </button>

            <a
                href="{{ route('profile.index') }}"
                class="block text-center text-gray-500 text-sm">

                ← Kembali

            </a>

        </form>

    </div>

</div>

@endsection