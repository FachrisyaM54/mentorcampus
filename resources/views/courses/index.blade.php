@extends('layouts.app')
@section('content')

<div class="bg-gray-100 h-screen pt-24 flex w-full overflow-hidden antialiased">

    <div class="w-80 h-full bg-white border-r border-gray-200 px-6 py-6 shrink-0 z-40 flex flex-col justify-between overflow-y-auto shadow-sm">
        <form method="GET" action="{{ route('courses.index') }}" class="flex flex-col h-full justify-between">
            <input type="hidden" name="search" value="{{ request('search') }}">

            <div class="space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800 text-base tracking-tight">
                        Filter Mentor
                    </h3>
                    @if(request('search') || request('subject') || request('kampus') || request('semester') || request('gender') || request('rating'))
                        <a href="{{ route('courses.index') }}" class="text-xs text-red-500 font-semibold hover:text-red-700 hover:underline transition">
                            Reset All
                        </a>
                    @endif
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-700 tracking-wide block mb-1.5">Subject / Skill</label>
                    <div class="relative">
                        <input type="text" name="subject" value="{{ request('subject') }}" placeholder="Algoritma, PHP..." class="w-full border border-gray-300 rounded-lg pl-3 pr-8 py-2 text-sm outline-none focus:border-[#175BAF] font-normal text-gray-600 transition bg-white">
                        @if(request('subject'))
                            <a href="{{ request()->fullUrlWithQuery(['subject' => '']) }}" class="absolute right-2.5 top-2.5 text-gray-400 hover:text-gray-600 text-xs">×</a>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-700 tracking-wide block mb-1.5">Campus</label>
                    <select name="kampus" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#175BAF] font-normal text-gray-600 bg-white transition cursor-pointer">
                        <option value="">All Campus</option>
                        @foreach ($kampusList as $kampus)
                            <option value="{{ $kampus->nama_kampus }}" {{ request('kampus') == $kampus->nama_kampus ? 'selected' : '' }}>
                                {{ $kampus->nama_kampus }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-700 tracking-wide block mb-1.5">Semester</label>
                    <select name="semester" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#175BAF] font-normal text-gray-600 bg-white transition cursor-pointer">
                        <option value="">All Semester</option>
                        <option value="1-2" {{ request('semester') == '1-2' ? 'selected' : '' }}>1 - 2</option>
                        <option value="3-4" {{ request('semester') == '3-4' ? 'selected' : '' }}>3 - 4</option>
                        <option value="5-6" {{ request('semester') == '5-6' ? 'selected' : '' }}>5 - 6</option>
                        <option value="7-8" {{ request('semester') == '7-8' ? 'selected' : '' }}>7 - 8</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-700 tracking-wide block mb-1.5">Gender</label>
                    <select name="gender" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#175BAF] font-normal text-gray-600 bg-white transition cursor-pointer">
                        <option value="">All Gender</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-700 tracking-wide block mb-1.5">Minimum Rating</label>
                    <select name="rating" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#175BAF] font-normal text-gray-600 bg-white transition cursor-pointer">
                        <option value="">All Rating</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐ 4+ Rating</option>
                        <option value="4.5" {{ request('rating') == '4.5' ? 'selected' : '' }}>⭐ 4.5+ Rating</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐ 5 Rating</option>
                    </select>
                </div>
            </div>

            <div class="mt-auto pt-4 border-t border-gray-100 bg-white sticky bottom-0">
                <button type="submit" class="w-full bg-[#175BAF] text-white py-2.5 rounded-xl text-sm font-semibold shadow hover:bg-blue-700 transition cursor-pointer">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <div class="flex-1 h-full overflow-y-auto pb-12">
        
        <section class="relative h-[200px] w-full overflow-hidden flex flex-col justify-center px-12">
            <div class="absolute inset-0 bg-black/30 z-10"></div>
            <img src="{{ asset('image/wanita-belajar.jpg') }}" class="absolute inset-0 w-full h-full object-cover z-0 object-center">
            
            <div class="relative z-20 text-white max-w-3xl">
                <h1 class="text-2xl font-semibold tracking-tight mb-4">
                    Find Your Mentor & Start Learning
                </h1>
                
                <form method="GET" action="{{ route('courses.index') }}" class="w-full">
                    @foreach(request()->except('search') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach

                    <div class="flex items-center bg-white rounded-full shadow-lg px-5 py-2 w-full max-w-2xl gap-3 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search mentor, skill, atau instansi..." class="w-full outline-none border-none ring-0 text-sm text-gray-700 bg-transparent placeholder-gray-400 font-normal">
                        <button type="submit" class="bg-[#175BAF] text-white text-xs font-semibold px-6 py-2 rounded-full hover:bg-blue-700 hover:scale-105 transition shrink-0 cursor-pointer">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <section class="px-12 py-8 w-full">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">
                    Recommended Mentors
                </h2>
                @if(request('search'))
                    <span class="text-xs text-gray-500 font-normal bg-white px-3 py-1 rounded-lg border border-gray-200">
                        Hasil pencarian untuk: <strong class="text-gray-700">"{{ request('search') }}"</strong>
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6 w-full">
                @forelse ($mentors as $mentor)
                    <div class="bg-white rounded-2xl border border-gray-200/80 overflow-hidden flex flex-col justify-between transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 group">
                        
                        <div class="w-full h-44 relative overflow-hidden bg-gray-900">
                            {{-- 💡 PERBAIKAN DI SINI: Ditambahkan timestamp (?t=time) agar foto profil langsung berubah real-time saat di-update --}}
                            @if (!empty($mentor->mentor->user->foto_profil) && $mentor->mentor->user->foto_profil != 'default.jpg')
    <img src="{{ asset('storage/' . ltrim($mentor->mentor->user->foto_profil, '/')) }}?t={{ time() }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
@else
                                <div class="w-full h-full bg-gradient-to-br from-[#B6DCFF] to-[#175BAF]/30 flex items-center justify-center text-4xl font-extrabold text-[#175BAF]/70">
                                    {{ strtoupper(substr($mentor->mentor->user->nama, 0, 1)) }}
                                </div>
                            @endif
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                            
                            <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-sm text-[#175BAF] font-semibold text-[10px] px-2 py-0.5 rounded-md shadow-sm">
                                Semester {{ $mentor->mentor->user->semester ?? '-' }}
                            </span>

                            <div class="absolute bottom-3 left-4 right-4 z-10">
                                <p class="text-[10px] text-gray-300 font-normal truncate">
                                    {{ $mentor->mentor->kampus->nama_kampus ?? 'Umum' }}
                                </p>
                                <h3 class="font-semibold text-white text-base tracking-tight truncate mt-0.5">
                                    {{ $mentor->mentor->user->nama }}
                                </h3>
                            </div>
                        </div>

                        <div class="p-4 flex-1 flex flex-col justify-between bg-white">
                            
                            <div class="space-y-3">
                                <div>
                                    <span class="text-xs font-medium text-gray-400 block mb-1">Keahlian</span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(explode(',', $mentor->mentor->spesialisasi) as $skill)
                                            <span class="bg-[#B6DCFF]/30 text-[#175BAF] text-[11px] font-medium px-2 py-0.5 rounded-md">
                                                {{ trim($skill) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="text-xs text-gray-500 truncate">
                                    <span class="text-gray-400 font-normal">Jurusan:</span> <span class="font-normal text-gray-600">{{ $mentor->mentor->jurusan }}</span>
                                </div>
                            </div>

                            <div class="mt-5 pt-3 border-t border-gray-100 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400 font-normal">Investasi belajar</span>
                                    <p class="text-[#175BAF] font-bold text-base tracking-tight">
                                        Rp {{ number_format($mentor->harga, 0, ',', '.') }}
                                        <span class="text-xs text-gray-400 font-normal">/session</span>
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 flex items-center gap-2 border border-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#175BAF]/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[11px] text-gray-500 font-normal truncate">
                                        {{ \Carbon\Carbon::parse($mentor->tanggal)->format('d M Y') }} &bull; 
                                        {{ \Carbon\Carbon::parse($mentor->jam)->format('H:i') }} - {{ \Carbon\Carbon::parse($mentor->jam_selesai)->format('H:i') }} WIB
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="px-4 pb-4 bg-white flex flex-col gap-2">
                            <div class="flex items-center justify-between text-xs">
                                @if($mentor->mentor->avg_rating > 0)
                                    <div class="flex items-center gap-1 font-medium text-amber-500">
                                        <span>⭐ {{ number_format($mentor->mentor->avg_rating, 1) }}</span>
                                        <span class="text-gray-400 font-normal">({{ $mentor->mentor->total_review }} ulasan)</span>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-[11px] font-normal">Belum ada ulasan</span>
                                @endif
                            </div>

                            <div class="grid grid-cols-5 gap-2 w-full">
                                <a href="{{ route('mentor.show', $mentor->id_mentor) }}" class="col-span-2 bg-gray-50 text-gray-500 border border-gray-200 py-2 rounded-xl text-xs font-medium text-center hover:bg-gray-100 transition shadow-sm">
                                    Detail
                                </a>
                                <a href="{{ route('booking.show', $mentor->id_schedule) }}" class="col-span-3 bg-[#175BAF] text-white py-2 rounded-xl text-xs font-semibold text-center hover:bg-blue-700 transition shadow-sm">
                                    Book Mentor
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl border border-gray-200/80 p-20 text-center text-gray-400 shadow-sm flex flex-col items-center justify-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-medium text-gray-500">Mentor tidak ditemukan</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10 flex justify-center sm:justify-start">
                {{ $mentors->links() }}
            </div>
        </section>
    </div>

</div>

@endsection