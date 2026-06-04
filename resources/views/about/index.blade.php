@extends('layouts.app')
@section('content')

<div class="pt-16">

    {{-- HERO --}}
    <section class="relative h-[550px] flex items-center px-6 md:px-20 overflow-hidden">

        <img
            src="{{ asset('image/mejabelajar.jpg') }}"
            class="absolute inset-0 w-full h-full object-cover">

        <div
            class="absolute inset-0 bg-gradient-to-r from-[#1D62B7]/80 to-[#1D62B7]/20">
        </div>

        <div class="relative z-10 max-w-2xl text-white">

            <span class="inline-block px-4 py-1 bg-blue-500/30 border border-blue-400 rounded-full text-xs font-bold uppercase tracking-widest mb-4">
                Our Story
            </span>

            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6">
                Connecting Minds,
                <br>
                <span class="text-blue-300">
                    Empowering
                </span>
                Futures.
            </h1>

            <p class="text-lg text-blue-50 leading-relaxed mb-8 opacity-90">
                MentorCampus adalah komunitas tempat mahasiswa saling berbagi ilmu,
                memecahkan kesulitan akademik, dan tumbuh bersama tanpa batasan
                formalitas yang kaku.
            </p>

            <a href="{{ route('courses.index') }}"
                class="inline-flex items-center gap-3 bg-white text-[#1D62B7] px-8 py-4 rounded-full font-bold shadow-lg hover:bg-blue-50 transition transform hover:-translate-y-1">

                Explore All Courses

                <i class="fas fa-arrow-right text-sm"></i>

            </a>

        </div>

    </section>

    {{-- STATS --}}
    <section class="relative z-20 -mt-12 px-6 md:px-20">

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="bg-white p-6 rounded-2xl shadow-xl text-center border-b-4 border-blue-500">
                <p class="text-3xl font-bold text-[#1D62B7]">500+</p>
                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mt-1">
                    Active Students
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl text-center border-b-4 border-blue-400">
                <p class="text-3xl font-bold text-[#1D62B7]">120+</p>
                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mt-1">
                    Verified Mentors
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl text-center border-b-4 border-blue-300">
                <p class="text-3xl font-bold text-[#1D62B7]">45+</p>
                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mt-1">
                    Subject Categories
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl text-center border-b-4 border-blue-200">
                <p class="text-3xl font-bold text-[#1D62B7]">4.9</p>
                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mt-1">
                    Average Rating
                </p>
            </div>

        </div>

    </section>

    {{-- VISI MISI --}}
    <section class="px-6 md:px-20 py-24">

        <div class="grid md:grid-cols-2 gap-16 items-center">

            <div>

                <h2 class="text-3xl font-bold text-[#2F5789] mb-6 border-l-4 border-blue-500 pl-4">
                    Visi & Misi Kami
                </h2>

                <p class="text-gray-600 leading-relaxed mb-8">
                    Kami percaya bahwa guru terbaik bagi seorang mahasiswa adalah
                    mahasiswa lainnya yang baru saja melewati tantangan yang sama.
                    Dengan pendekatan
                    <span class="font-bold text-blue-600">
                        Peer-to-Peer Learning
                    </span>,
                    kami menciptakan ruang belajar yang nyaman dan terjangkau.
                </p>

                <div class="grid sm:grid-cols-2 gap-6">

                    <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                        <i class="fas fa-check-circle text-blue-500 mb-2"></i>
                        <h4 class="font-bold text-sm text-[#2F5789]">
                            Accessible
                        </h4>
                        <p class="text-[11px] text-gray-500">
                            Akses materi kapan saja dan di mana saja.
                        </p>
                    </div>

                    <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                        <i class="fas fa-wallet text-green-500 mb-2"></i>
                        <h4 class="font-bold text-sm text-[#2F5789]">
                            Affordable
                        </h4>
                        <p class="text-[11px] text-gray-500">
                            Harga yang sangat bersahabat bagi mahasiswa.
                        </p>
                    </div>

                </div>

            </div>

            <div>

                <div class="w-full h-[350px] rounded-3xl overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition duration-500">

                    <img
                        src="{{ asset('image/priabelajar.jpg') }}"
                        class="w-full h-full object-cover">

                </div>

            </div>

        </div>

    </section>

    {{-- TEAM --}}
    <section class="bg-white py-24 px-6 md:px-20">

        <div class="text-center max-w-3xl mx-auto mb-16">

            <h2 class="text-3xl font-bold text-[#2F5789] mb-4">
                Meet Our Team
            </h2>

            <p class="text-gray-500">
                Para pengembang di balik platform MentorCampus.
            </p>

        </div>

        <div class="grid md:grid-cols-3 gap-12">

            {{-- Member 1 --}}
            <div class="group text-center">

                <div class="relative inline-block mb-6">

                    <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-blue-50 shadow-lg group-hover:border-blue-400 transition">

                        <img
                            src="{{ asset('image/raya.jpeg') }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">

                    </div>

                    <div class="absolute bottom-2 right-2 bg-[#1D62B7] text-white text-[10px] px-3 py-1 rounded-full font-bold">
                        UPNV Jawa Timur
                    </div>

                </div>

                <h3 class="text-lg font-bold text-[#2F5789]">
                    Dishwar Raya Pradipta
                </h3>

                <p class="text-sm text-blue-400 tracking-widest">
                    24082010008
                </p>

            </div>

            {{-- Member 2 --}}
            <div class="group text-center">

                <div class="relative inline-block mb-6">

                    <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-blue-50 shadow-lg group-hover:border-blue-400 transition">

                        <img
                            src="{{ asset('image/fachris.jpeg') }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">

                    </div>

                    <div class="absolute bottom-2 right-2 bg-[#1D62B7] text-white text-[10px] px-3 py-1 rounded-full font-bold">
                        UPNV Jawa Timur
                    </div>

                </div>

                <h3 class="text-lg font-bold text-[#2F5789]">
                    Fachrisya Maula Ardhi
                </h3>

                <p class="text-sm text-blue-400 tracking-widest">
                    24082010023
                </p>

            </div>

            {{-- Member 3 --}}
            <div class="group text-center">

                <div class="relative inline-block mb-6">

                    <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-blue-50 shadow-lg group-hover:border-blue-400 transition">

                        <img
                            src="{{ asset('image/nissaa.jpeg') }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">

                    </div>

                    <div class="absolute bottom-2 right-2 bg-[#1D62B7] text-white text-[10px] px-3 py-1 rounded-full font-bold">
                        UPNV Jawa Timur
                    </div>

                </div>

                <h3 class="text-lg font-bold text-[#2F5789]">
                    Nissa Febriyanti
                </h3>

                <p class="text-sm text-blue-400 tracking-widest">
                    24082010028
                </p>

            </div>

        </div>

    </section>

    {{-- CTA --}}
    <section class="px-6 md:px-20 py-20 bg-gray-50">

        <div class="bg-[#1D62B7] rounded-[40px] p-12 text-center text-white shadow-2xl">

            <h2 class="text-3xl md:text-4xl font-extrabold mb-6">
                Siap Memulai Perjalanan Akademikmu?
            </h2>

            <p class="text-blue-100 mb-10 max-w-xl mx-auto">
                Gabung sekarang dan temukan mentor yang paling mengerti cara belajarmu.
            </p>

            <a
                href="{{ route('courses.index') }}"
                class="inline-block bg-white text-[#1D62B7] px-10 py-4 rounded-full font-bold hover:bg-blue-50 transition">

                Cari Mentor Sekarang

            </a>

        </div>

    </section>

</div>

@endsection