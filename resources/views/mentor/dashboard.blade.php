@extends('layouts.app')

@section('content')
{{-- MAIN WRAPPER: Diubah menjadi flex layout untuk memisahkan sidebar kiri (full height & mepet layar) --}}
<div class="bg-[#F8FAFC] min-h-screen pt-20 flex font-sans antialiased">

    {{-- SIDEBAR KIRI: Dibuat mepet total tanpa padding kontainer luar, lebar diset kaku (w-80 atau w-96 sesuai selera) --}}
    <div class="relative w-80 min-h-[calc(100vh-5rem)] bg-[#175BAF] text-white p-6 shadow-md border-r border-blue-600/20 flex flex-col justify-between shrink-0">
        
        {{-- BACKGROUND IMAGE OVERLAY --}}
        <div class="absolute inset-0 bg-cover bg-center mix-blend-overlay opacity-25" style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=600&auto=format&fit=crop');"></div>
        
        {{-- TOP SIDEBAR: Profile Singkat & Ringkasan Sesi --}}
        <div class="relative z-10 flex flex-col items-center text-center">
            <div class="w-20 h-20 rounded-full border-2 border-white/40 overflow-hidden bg-white/10 mb-3 flex items-center justify-center shadow-inner">
                @if(!empty($user->foto_profil) && $user->foto_profil != 'default.jpg')
                    <img src="{{ asset('storage/' . ltrim($user->foto_profil, '/')) }}?t={{ time() }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-2xl font-light text-white/80 bg-gradient-to-tr from-white/10 to-white/20">
                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                    </div>
                @endif
            </div>
            <h3 class="font-bold text-base tracking-tight leading-snug">{{ $user->nama }}</h3>
            <p class="text-[11px] text-blue-100 font-light mt-0.5">{{ $user->email }}</p>

            <div class="w-full h-[1px] bg-white/10 my-5"></div>

            {{-- RINGKASAN STATISTIK SESI --}}
            <div class="w-full text-left space-y-2.5">
                <p class="text-[10px] font-bold text-blue-200 uppercase tracking-widest mb-1">Ringkasan Sesi</p>
                
                <div class="flex items-center justify-between bg-white/10 border border-white/10 rounded-xl px-3.5 py-2 text-xs">
                    <span class="font-medium text-blue-100">Total Sesi</span>
                    <span class="font-bold bg-white/20 px-2 py-0.5 rounded-md">{{ $totalBooking }}</span>
                </div>
                
                <div class="flex items-center justify-between bg-white/10 border border-white/10 rounded-xl px-3.5 py-2 text-xs">
                    <span class="font-medium text-blue-100">Sesi Selesai</span>
                    <span class="font-bold text-emerald-300 bg-white/20 px-2 py-0.5 rounded-md">{{ $completedBooking }}</span>
                </div>
                
                <div class="flex items-center justify-between bg-white/10 border border-white/10 rounded-xl px-3.5 py-2 text-xs">
                    <span class="font-medium text-blue-100">Sesi Berjalan</span>
                    <span class="font-bold text-amber-300 bg-white/20 px-2 py-0.5 rounded-md">{{ $ongoingBooking }}</span>
                </div>

                <div class="flex items-center justify-between bg-white/10 border border-white/10 rounded-xl px-3.5 py-2 text-xs">
                    <span class="font-medium text-blue-100">Total Jadwal</span>
                    <span class="font-bold text-blue-200 bg-white/20 px-2 py-0.5 rounded-md">{{ $totalSchedule }}</span>
                </div>
            </div>
        </div>

        {{-- BOTTOM SIDEBAR: RECENT BOOKINGS LIST --}}
        <div class="relative z-10 mt-6 pt-5 border-t border-white/10 text-left">
            <p class="text-[10px] font-bold text-blue-200 uppercase tracking-widest mb-2">Recent Booking</p>
            <div class="space-y-2 max-h-[180px] overflow-y-auto pr-1 text-xs style-scrollbar">
                @forelse($recentBookings as $booking)
                    <div class="bg-black/10 hover:bg-black/15 border border-white/5 p-2.5 rounded-xl transition-colors">
                        <p class="font-semibold text-white truncate">{{ $booking->student?->nama ?? 'Mahasiswa' }}</p>
                        <div class="flex items-center justify-between text-[10px] text-blue-200 mt-0.5">
                            <span class="capitalize">{{ $booking->status }}</span>
                            <span>{{ $booking->schedule?->tanggal ? \Carbon\Carbon::parse($booking->schedule->tanggal)->format('d M') : '' }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-blue-200/60 text-[11px] italic font-light py-2">Belum ada riwayat booking.</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- AREA KONTEN KANAN: Diberikan fleksibilitas penuh mengisi sisa ruang --}}
    <div class="flex-1 p-8 lg:p-10 max-w-5xl">

        {{-- HEADER SECTION --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-950 tracking-tight">Mentor Dashboard</h1>
            <p class="text-xs text-slate-500 mt-1 font-normal">Pantau performa mentoring, jadwal aktif, dan kelola kredensial publik Anda.</p>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-xs font-semibold shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- FORM UTAMA KREDENSIAL --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
            <div class="pb-4 mb-6 border-b border-slate-100">
                <h2 class="font-bold text-lg text-slate-900 tracking-tight">Profil & Kredensial Mentor</h2>
                <p class="text-xs text-slate-400 mt-0.5">Informasi di bawah ini akan ditampilkan secara publik pada halaman detail mentor agar student tertarik memilih Anda.</p>
            </div>

            <form action="{{ route('mentor.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                {{-- INPUT BIOGRAFI SINGKAT --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Biografi Singkat</label>
                    <textarea name="biografi" rows="8" placeholder="Ceritakan latar belakang akademis, keahlian, atau pengalaman mengajar Anda dengan menarik..." class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:outline-none focus:border-[#175BAF] focus:ring-1 focus:ring-[#175BAF] transition-all bg-slate-50/30 placeholder:text-slate-400 leading-relaxed @error('biografi') border-red-500 bg-red-50/10 @enderror">{{ old('biografi', $mentor->biografi ?? ($user->calonMentor->biografi ?? '')) }}</textarea>
                    @error('biografi')
                        <p class="text-red-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- INPUT SERTIFIKAT PENDUKUNG --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Sertifikat Pendukung (PDF/Gambar)</label>
                    <p class="text-[11px] text-slate-400 mb-3">Unggah sertifikat keahlian, prestasi, atau bukti kompetensi pendukung resmi Anda.</p>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 bg-slate-50 border border-dashed border-slate-200 p-4 rounded-xl">
                        <input type="file" name="sertifikat" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#175BAF] hover:file:bg-blue-100/80 transition-colors cursor-pointer">
                        
                        @if(!empty($user->file_sertifikat))
                            <div class="shrink-0 flex items-center gap-2 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm w-fit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <a href="{{ asset('storage/' . $user->file_sertifikat) }}" target="_blank" class="text-xs text-[#175BAF] font-semibold hover:underline flex items-center gap-0.5">
                                    Lihat Berkas ↗
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    @error('sertifikat')
                        <p class="text-red-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- BUTTON SIMPAN --}}
                <div class="pt-2 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="w-full sm:w-auto bg-[#175BAF] hover:bg-blue-700 text-white font-semibold text-xs px-5 py-3 rounded-xl shadow transition-all transform active:scale-[0.98] cursor-pointer">
                        Simpan & Perbarui Profil Mentor
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<style>
    /* Styling pemanis untuk scrollbar recent booking agar serasi tipis */
    .style-scrollbar::-webkit-scrollbar { width: 4px; }
    .style-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); border-radius: 10px; }
    .style-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
    .style-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.4); }
</style>
@endsection