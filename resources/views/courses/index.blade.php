@extends('layouts.app')
@section('content')

<div class="bg-gray-100 min-h-screen pt-24">

    {{-- HERO --}}
    <section class="relative h-[400px] overflow-hidden">

        <img src="{{ asset('image/wanita-belajar.jpg') }}"
             class="absolute w-full h-full object-cover z-0">

        <div class="absolute inset-0 bg-black/30 z-10"></div>

        <div class="relative z-20 px-12 pt-28 text-white">

            <h1 class="text-3xl font-semibold mb-6">
                Find Your Mentor & Start Learning
            </h1>

            {{-- SEARCH --}}
            <form method="GET" action="{{ route('courses.index') }}">

                <div class="flex items-center bg-white rounded-full shadow-lg px-4 py-2 w-[600px]">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 text-gray-400 mr-2"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />

                    </svg>

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search mentor, skill..."
                           class="w-full outline-none text-sm text-gray-600 bg-transparent">

                    <button type="submit"
                            class="bg-[#175BAF] text-white text-sm px-4 py-1.5 rounded-full hover:scale-105 transition">
                        Search
                    </button>

                </div>

            </form>

        </div>

    </section>

    {{-- MAIN --}}
    <section class="px-12 py-10 grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- LEFT --}}
        <div class="lg:col-span-2">

            <div class="flex justify-between items-center mb-6">

                <h2 class="text-xl font-semibold">
                    Recommended Mentors
                </h2>

            </div>

            <div class="space-y-6">

                @forelse ($mentors as $mentor)

                    <div class="bg-white rounded-xl shadow p-5 flex gap-5 items-center hover:shadow-lg transition relative">

                        {{-- FOTO --}}
                        @if (
                            !empty($mentor->mentor->user->foto_profil)
                            && $mentor->mentor->user->foto_profil != 'default.jpg'
                        )

                            <img src="{{ asset($mentor->mentor->user->foto_profil) }}"
                                 class="w-32 h-32 object-cover rounded-full">

                        @else

                            <div class="w-32 h-32 rounded-full bg-[#B6DCFF] flex items-center justify-center text-3xl font-bold text-[#175BAF]">

                                {{ strtoupper(substr($mentor->mentor->user->nama, 0, 1)) }}

                            </div>

                        @endif

                        {{-- CONTENT --}}
                        <div class="flex-1 pb-10">

                            <p class="text-sm text-gray-500">

                                {{ $mentor->mentor->kampus->nama_kampus ?? '-' }}
                                •
                                Semester {{ $mentor->mentor->user->semester ?? '-' }}

                            </p>

                            <h3 class="font-semibold text-lg">

                                {{ $mentor->mentor->user->nama }}

                            </h3>

                            <p class="text-[#175BAF] font-semibold mt-2">

                                Rp {{ number_format($mentor->harga, 0, ',', '.') }}

                                <span class="text-xs text-gray-400">
                                    /45 Menit
                                </span>

                            </p>

                            <div class="text-sm text-gray-500 mt-1">

                                {{ $mentor->mentor->jurusan }}
                                •
                                {{ $mentor->mentor->spesialisasi }}

                            </div>

                            <p class="text-sm text-gray-500 mt-1">

                                {{ \Carbon\Carbon::parse($mentor->tanggal)->format('d M Y') }}
                                •

                                {{ \Carbon\Carbon::parse($mentor->jam)->format('H:i') }}
                                WIB

                            </p>

                            {{-- RATING --}}
                            @if (!empty($mentor->avg_rating))

                                <span class="text-yellow-500 font-semibold">
                                    ⭐ {{ number_format($mentor->avg_rating, 1) }}
                                </span>

                                <span class="text-gray-500 text-xs">
                                    ({{ $mentor->total_review }} review)
                                </span>

                            @else

                                <span class="text-gray-400 text-sm">
                                    Belum ada rating
                                </span>

                            @endif

                            {{-- BUTTON --}}
                            <div class="flex gap-2 mt-3">

                                <a href="#"
                                   class="bg-gray-100 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">

                                    Detail

                                </a>

                                <a href="{{ route('booking.show', $mentor->id_schedule) }}"
                                   class="bg-[#175BAF] text-white px-5 py-2 rounded-xl text-sm font-semibold shadow-md hover:scale-105 transition">

                                    Book

                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="text-center text-gray-500 py-10">

                        Mentor not found 😢

                    </div>

                @endforelse

            </div>

            {{-- PAGINATION --}}
            <div class="mt-10">

                {{ $mentors->links() }}

            </div>

        </div>

        {{-- RIGHT FILTER --}}
        <div class="bg-white rounded-xl shadow p-6 self-start h-fit">

            <form method="GET"
                  action="{{ route('courses.index') }}">

                <h3 class="font-semibold mb-4 text-lg border-b pb-2">
                    Filter Mentor
                </h3>

                {{-- SUBJECT --}}
                <div class="mb-4">

                    <label class="text-sm font-medium text-gray-700">
                        Subject
                    </label>

                    <input type="text"
                           name="subject"
                           value="{{ request('subject') }}"
                           placeholder="Algoritma, PHP..."
                           class="w-full border rounded-lg px-3 py-2 text-sm mt-1 focus:ring-2 focus:ring-blue-500 outline-none">

                </div>

                {{-- KAMPUS --}}
                <div class="mb-4">

                    <label class="text-sm font-medium text-gray-700">
                        Campus
                    </label>

                    <select name="kampus"
                            class="w-full border rounded-lg px-3 py-2 text-sm mt-1 focus:ring-2 focus:ring-blue-500 outline-none">

                        <option value="">
                            All Campus
                        </option>

                        @foreach ($kampusList as $kampus)

                            <option value="{{ $kampus->nama_kampus }}"
                                {{ request('kampus') == $kampus->nama_kampus ? 'selected' : '' }}>

                                {{ $kampus->nama_kampus }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- SEMESTER --}}
                <div class="mb-4">

                    <label class="text-sm font-medium text-gray-700">
                        Semester
                    </label>

                    <select name="semester"
                            class="w-full border rounded-lg px-3 py-2 text-sm mt-1 focus:ring-2 focus:ring-blue-500 outline-none">

                        <option value="">All Semester</option>

                        <option value="1-2"
                            {{ request('semester') == '1-2' ? 'selected' : '' }}>
                            1 - 2
                        </option>

                        <option value="3-4"
                            {{ request('semester') == '3-4' ? 'selected' : '' }}>
                            3 - 4
                        </option>

                        <option value="5-6"
                            {{ request('semester') == '5-6' ? 'selected' : '' }}>
                            5 - 6
                        </option>

                        <option value="7-8"
                            {{ request('semester') == '7-8' ? 'selected' : '' }}>
                            7 - 8
                        </option>

                    </select>

                </div>

                {{-- GENDER --}}
                <div class="mb-6">

                    <label class="text-sm font-medium text-gray-700">
                        Gender
                    </label>

                    <select name="gender"
                            class="w-full border rounded-lg px-3 py-2 text-sm mt-1 focus:ring-2 focus:ring-blue-500 outline-none">

                        <option value="">
                            All Gender
                        </option>

                        <option value="male"
                            {{ request('gender') == 'male' ? 'selected' : '' }}>
                            Male
                        </option>

                        <option value="female"
                            {{ request('gender') == 'female' ? 'selected' : '' }}>
                            Female
                        </option>

                    </select>

                </div>

                {{-- BUTTON --}}
                <button type="submit"
                        class="w-full bg-[#175BAF] text-white py-2.5 rounded-lg text-sm font-bold shadow-lg hover:bg-blue-700 transition">

                    Apply Filters

                </button>

                {{-- RESET --}}
                @if (
                    request('search')
                    || request('subject')
                    || request('kampus')
                    || request('semester')
                    || request('gender')
                )

                    <a href="{{ route('courses.index') }}"
                       class="block text-center text-xs text-red-500 mt-4 font-semibold hover:underline">

                        Reset All Filters

                    </a>

                @endif

            </form>

        </div>

    </section>

</div>

@endsection