@extends('layouts.app')

@section('content')
{{-- MAIN WRAPPER: Menggunakan font modern minimalis, tracking tight, dan antialiased --}}
<div class="min-h-screen bg-[#F8FAFC] font-sans antialiased flex flex-col lg:flex-row pt-20">
    
    {{-- Mengunci posisi di kiri layar, nempel dari atas-bawah, border kanan clean tanpa shadow lebay --}}
    <div class="w-full lg:w-[340px] lg:fixed lg:top-20 lg:bottom-0 lg:left-0 bg-white border-r border-gray-200 p-8 flex flex-col items-center overflow-y-auto z-10">
        
        <div class="w-full mb-6 text-left">
            <a href="{{ route('courses.index') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-gray-400 hover:text-[#175BAF] transition gap-1 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
                Jelajah Mentor
            </a>
        </div>

        <div class="w-28 h-28 rounded-full border border-gray-100 overflow-hidden bg-gray-50 mb-4 flex items-center justify-center shadow-sm">
    @if(!empty($mentor->user->foto_profil) && $mentor->user->foto_profil != 'default.jpg')
        {{-- 💡 PERBAIKAN: Ditambahkan 'storage/' dan anti-cache ?t= --}}
        <img src="{{ asset('storage/' . ltrim($mentor->user->foto_profil, '/')) }}?t={{ time() }}" class="w-full h-full object-cover">
    @else
        <div class="w-full h-full bg-gradient-to-tr from-slate-100 to-slate-200/60 flex items-center justify-center text-3xl font-light text-slate-400">
            {{ strtoupper(substr($mentor->user->nama, 0, 1)) }}
        </div>
    @endif
</div>

        <h1 class="text-xl font-bold text-slate-800 tracking-tight text-center leading-snug">
            {{ $mentor->user->nama }}
        </h1>
        <p class="text-xs font-medium text-[#175BAF] mt-1.5 px-2.5 py-0.5 bg-blue-50 text-center rounded-md">
            {{ $mentor->kampus->nama_kampus ?? 'Umum' }}
        </p>

        <div class="mt-3 flex items-center gap-1 bg-slate-50 px-3 py-1 rounded-md border border-slate-100 text-xs font-medium text-slate-600">
            @if($avgRating > 0)
                <span class="text-amber-500 font-semibold">★ {{ number_format($avgRating, 1) }}</span>
                <span class="text-slate-300">•</span>
                <span>{{ $totalReview }} Ulasan</span>
            @else
                <span class="text-slate-400">Belum ada rating</span>
            @endif
        </div>

        <div class="w-full h-[1px] bg-slate-100 my-6"></div>

        <div class="w-full space-y-4 text-left text-sm">
            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Jenis Kelamin</label>
                <span class="font-medium text-slate-700 mt-0.5 block capitalize">
                    @if(($mentor->user->gender ?? '') == 'male') Laki-laki
                    @elseif(($mentor->user->gender ?? '') == 'female') Perempuan
                    @else {{ $mentor->user->gender ?? '-' }} @endif
                </span>
            </div>

            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Usia</label>
                <span class="font-medium text-slate-700 mt-0.5 block">
                    {{ $mentor->calonMentor->usia ?? ($mentor->user->calonMentor->usia ?? '-') }} Tahun
                </span>
            </div>

            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Fakultas / Jurusan</label>
                <span class="font-medium text-slate-700 mt-0.5 block leading-normal">
                    {{ $mentor->fakultas }} <span class="text-slate-300">/</span> {{ $mentor->jurusan }}
                </span>
            </div>

            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Spesialisasi</label>
                <div class="flex flex-wrap gap-1">
                    @foreach(explode(',', $mentor->spesialisasi) as $skill)
                        <span class="bg-slate-100 text-slate-600 text-[11px] px-2 py-0.5 rounded font-medium">
                            {{ trim($skill) }}
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="pt-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1.5">Sertifikasi</label>
                {{-- 💡 PERBAIKAN: Ditambahkan 'storage/' agar mengambil file_sertifikat dari folder yang benar --}}
                @if(!empty($mentor->user->file_sertifikat))
                    <a href="{{ asset('storage/' . $mentor->user->file_sertifikat) }}" target="_blank" class="w-full flex items-center justify-between border border-slate-200 bg-white hover:border-blue-500 hover:text-[#175BAF] p-2 rounded-lg transition text-slate-600 text-xs font-medium shadow-sm group">
                        <span class="truncate">Sertifikat Terverifikasi</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 opacity-60 group-hover:opacity-100 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @else
                    <div class="p-2 border border-dashed border-slate-200 rounded-lg text-slate-400 text-xs text-center font-normal">
                        Belum mengunggah berkas
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Diberikan lg:ml-[340px] agar konten kanan bergeser pas di samping area fixed sidebar kiri --}}
    <div class="flex-1 lg:ml-[340px] p-8 lg:p-12 space-y-8 overflow-x-hidden">
        
        <div class="bg-white rounded-xl border border-gray-200/70 p-6 shadow-sm">
            <h2 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">Biografi</h2>
            <p class="text-sm text-slate-600 leading-relaxed font-normal">
                {{ $mentor->biografi ?: 'Mentor belum menuliskan biografi singkat.' }}
            </p>
            
            @if($mentor->pengalaman)
                <div class="h-[1px] bg-slate-100 my-5"></div>
                <h2 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Pengalaman</h2>
                <p class="text-sm text-slate-600 leading-relaxed font-normal">
                    {{ $mentor->pengalaman }}
                </p>
            @endif
        </div>

        <div class="bg-white rounded-xl border border-gray-200/70 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-xs font-bold uppercase tracking-widest text-slate-400">Jadwal Mentoring Tersedia</h2>
                <span class="text-[11px] font-medium text-slate-400 bg-slate-50 px-2 py-0.5 border border-slate-100 rounded">Zona Waktu WIB</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @forelse($schedules as $schedule)
                    <div class="border border-slate-200/60 bg-white rounded-xl p-4 flex flex-col justify-between hover:border-blue-400 transition shadow-sm hover:shadow-md/5 group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs font-bold text-slate-700">
                                    {{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}
                                </span>
                                <span class="text-[#175BAF] font-bold text-sm">
                                    Rp {{ number_format($schedule->harga, 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium">
                                    {{ \Carbon\Carbon::parse($schedule->jam)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('booking.show', $schedule->id_schedule) }}" class="w-full inline-block bg-[#175BAF] text-white text-xs font-semibold py-2 rounded-lg text-center hover:bg-blue-700 transition shadow-sm">
                                Ambil Sesi Mentoring
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full border border-dashed border-slate-200 rounded-xl p-8 text-center text-slate-400 flex flex-col items-center justify-center gap-2">
                        <p class="text-xs font-normal">Saat ini belum ada jadwal kelas yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200/70 p-6 shadow-sm">
            <h2 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4">Ulasan dari Mahasiswa</h2>

            <div class="divide-y divide-slate-100">
                @forelse($reviews as $review)
                    <div class="py-4 first:pt-0 last:pb-0">
                        <div class="flex items-center justify-between">
                            <strong class="text-xs font-bold text-slate-700">
                                {{ $review->booking->student->nama ?? 'Mahasiswa' }}
                            </strong>
                            <span class="text-amber-500 text-xs font-bold">
                                ★ {{ $review->rating }}.0
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 font-normal mt-2 bg-slate-50/50 p-3 rounded-lg border border-slate-100/80 italic leading-relaxed">
                            "{{ $review->komentar ?: 'Tidak menyertakan ulasan tertulis.' }}"
                        </p>
                    </div>
                @empty
                    <div class="py-4 text-center text-slate-400 text-xs font-normal">
                        Belum ada riwayat ulasan untuk mentor ini.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection