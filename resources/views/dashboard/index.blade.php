<x-app-layout>
@extends('layouts.app')
@section('contents')

<div class="pt-20">

<section class="relative h-[500px] flex items-center justify-center overflow-hidden">
    
    <img src="{{ asset('image/pena.jpg') }}" 
         class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 hero-overlay"></div>

    <div class="relative z-10 text-center px-6 max-w-3xl">

        <span class="inline-block px-4 py-1 bg-blue-500/30 border border-blue-400 rounded-full text-xs font-bold text-blue-100 uppercase tracking-widest mb-4">
            Welcome back, {{ Auth::user()->nama }} 👋
        </span>

        <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
            Temukan Mentor <br>
            <span class="text-blue-400">Terbaikmu</span> Sekarang.
        </h1>

        <p class="text-blue-50 text-base md:text-lg mb-8 opacity-90">
            Akses ribuan mentor mahasiswa yang siap membantumu menguasai materi kuliah dengan cara yang lebih seru dan mudah dipahami.
        </p>

        <a href="{{ url('/courses') }}"
           class="inline-block bg-[#175BAF] text-white px-10 py-4 rounded-full font-bold shadow-2xl hover:bg-blue-600 transition transform hover:scale-105 active:scale-95">

            Mulai Belajar Sekarang

        </a>

    </div>

</section>

<div class="max-w-6xl mx-auto px-6 -mt-10 relative z-20">

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <h4 class="text-2xl font-bold text-[#175BAF]">12</h4>
            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">
                Kelas Saya
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <h4 class="text-2xl font-bold text-[#175BAF]">150+</h4>
            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">
                Mentor Aktif
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <h4 class="text-2xl font-bold text-[#175BAF]">4.8</h4>
            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">
                Rating Kepuasan
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
            <h4 class="text-2xl font-bold text-[#175BAF]">24/7</h4>
            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">
                Dukungan Belajar
            </p>
        </div>

    </div>

</div>

<section class="max-w-6xl mx-auto px-6 py-20">

    <div class="flex justify-between items-end mb-10">

        <div>
            <h2 class="text-3xl font-bold text-[#2F5789]">
                Kategori Populer
            </h2>

            <p class="text-gray-500 mt-2 text-sm">
                Pilih bidang yang ingin kamu kuasai hari ini.
            </p>
        </div>

        <a href="{{ url('/courses') }}"
           class="text-[#175BAF] font-bold text-sm hover:underline">

            Lihat Semua →

        </a>

    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        <div class="group bg-white p-8 rounded-3xl border border-gray-100 hover:border-blue-200 transition text-center cursor-pointer shadow-sm hover:shadow-xl">
            <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-500 transition-colors">
                <i class="fas fa-code text-2xl text-blue-500 group-hover:text-white"></i>
            </div>

            <h4 class="font-bold text-[#2F5789]">Programming</h4>
        </div>

        <div class="group bg-white p-8 rounded-3xl border border-gray-100 hover:border-blue-200 transition text-center cursor-pointer shadow-sm hover:shadow-xl">
            <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-500 transition-colors">
                <i class="fas fa-pen-nib text-2xl text-orange-500 group-hover:text-white"></i>
            </div>

            <h4 class="font-bold text-[#2F5789]">Design UI/UX</h4>
        </div>

        <div class="group bg-white p-8 rounded-3xl border border-gray-100 hover:border-blue-200 transition text-center cursor-pointer shadow-sm hover:shadow-xl">
            <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-green-500 transition-colors">
                <i class="fas fa-calculator text-2xl text-green-500 group-hover:text-white"></i>
            </div>

            <h4 class="font-bold text-[#2F5789]">Mathematics</h4>
        </div>

        <div class="group bg-white p-8 rounded-3xl border border-gray-100 hover:border-blue-200 transition text-center cursor-pointer shadow-sm hover:shadow-xl">
            <div class="w-16 h-16 bg-purple-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-500 transition-colors">
                <i class="fas fa-language text-2xl text-purple-500 group-hover:text-white"></i>
            </div>

            <h4 class="font-bold text-[#2F5789]">Languages</h4>
        </div>

    </div>

</section>

<footer class="bg-[#F5F7FA] py-12 text-center border-t">

    <p class="text-gray-400 text-xs font-bold uppercase tracking-[0.4em]">
        &copy; 2026 MentorCampus. Created for Excellence.
    </p>

</footer>
</div>
</x-app-layout>