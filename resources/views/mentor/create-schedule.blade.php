@extends('layouts.app')

@section('content')
<div class="bg-[#FAFAFA] min-h-screen pt-24 pb-12 font-sans antialiased text-slate-800">
    <div class="max-w-md mx-auto px-4 sm:px-6">

        <div class="mb-4">
            <a href="{{ route('mentor.schedule') }}" class="text-sm font-medium text-slate-500 hover:text-[#175BAF] inline-flex items-center gap-1 transition-colors">
                ← Kembali ke Jadwal Saya
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="mb-6">
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Tambah Jadwal Baru</h1>
                <p class="text-sm text-slate-500 mt-1">Tentukan tanggal, rentang jam sesi, dan harga mentoring kamu.</p>
            </div>

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-100 text-rose-700 px-4 py-2.5 rounded-xl mb-4 text-sm font-medium text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('mentor.schedule.store') }}" class="space-y-4">
                @csrf

                {{-- TANGGAL --}}
                <div>
                    <label for="tanggal" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Tanggal Mentoring</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" required
                           min="{{ date('Y-m-d') }}"
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-slate-800 text-sm outline-none focus:border-[#175BAF] focus:ring-1 focus:ring-[#175BAF] transition-all shadow-sm">
                </div>

                {{-- DUAL INPUT JAM (Mulai & Selesai) --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="jam" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Jam Mulai</label>
                        <input type="time" name="jam" id="jam" value="{{ old('jam') }}" required
                               class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-slate-800 text-sm outline-none focus:border-[#175BAF] focus:ring-1 focus:ring-[#175BAF] transition-all shadow-sm">
                    </div>
                    <div>
                        <label for="jam_selesai" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') }}" required
                               class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-slate-800 text-sm outline-none focus:border-[#175BAF] focus:ring-1 focus:ring-[#175BAF] transition-all shadow-sm">
                    </div>
                </div>

                {{-- HARGA --}}
                <div>
                    <label for="harga" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Harga Sesi</label>
                    <div class="relative shadow-sm rounded-xl">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm select-none font-medium">Rp</span>
                        <input type="number" name="harga" id="harga" value="{{ old('harga') }}" placeholder="Contoh: 50000" required min="0"
                               class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-slate-800 text-sm outline-none focus:border-[#175BAF] focus:ring-1 focus:ring-[#175BAF] transition-all">
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#175BAF] text-white py-3 rounded-xl text-sm font-bold hover:bg-blue-700 transition shadow-sm active:scale-[0.99] cursor-pointer">
                        Simpan Jadwal Mentoring
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection