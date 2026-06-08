@extends('layouts.app')

@section('content')
{{-- CONTAINER UTAMA FULL SCREEN DAN FLUSH --}}
<div class="bg-gray-50 min-h-screen w-full pt-16">
    
    {{-- RASIO JAGA 1:5 (20% KIRI, 80% KANAN) --}}
    <div class="grid md:grid-cols-5 min-h-[calc(100vh-64px)] items-start">

        {{-- ==================== KIRI: CARD PROFIL BACKGROUND WANITA-BELAJAR OVERLAY GRADIENT ==================== --}}
        <div class="md:sticky md:top-16 relative overflow-hidden h-full md:min-h-[calc(100vh-64px)] p-5 flex flex-col justify-between md:col-span-1 shadow-2xl border-r border-blue-900/10">
            
            {{-- 1. FOTO BACKGROUND & OVERLAY GRADASI BIRU MATANG --}}
            <img src="{{ asset('image/wanita-belajar.jpg') }}" class="absolute inset-0 w-full h-full object-cover z-0">
            <div class="absolute inset-0 bg-gradient-to-b from-[#104380]/95 via-[#175BAF]/90 to-[#1d6bca]/95 z-0"></div>

            {{-- KONTEN ELEMEN ATAS (Z-10 SUPAYA DI ATAS FOTO) --}}
            <div class="relative z-10 text-white">
                
                {{-- FOTO PROFIL UTAMA --}}
                <div class="relative group w-20 h-20 mx-auto mb-4">
                    @if($user->foto_profil)
                        <img src="{{ asset('storage/'.$user->foto_profil) }}" class="w-20 h-20 rounded-full object-cover border-2 border-white/80 shadow-md">
                    @else
                        <div class="w-20 h-20 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-2xl font-bold text-white border-2 border-white/30 shadow-sm">
                            {{ strtoupper(substr($user->nama, 0, 1)) }}
                        </div>
                    @endif
                </div>

                {{-- DETAIL USER ELEMEN OTOMATIS SESSION --}}
                <div class="text-center mb-5">
                    <h2 class="text-base font-bold tracking-wide leading-tight">{{ $user->nama }}</h2>
                    <p class="text-[11px] text-blue-200 font-light mt-0.5 break-all">{{ $user->email }}</p>
                </div>

                <div class="text-xs font-bold tracking-wider text-blue-200/60 uppercase mb-3">Edit Profil</div>

                {{-- FORM UPDATE DATA --}}
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5">
                    @csrf
                    <div>
                        <label class="text-[11px] font-medium text-blue-100 block mb-1">Nama Pengguna</label>
                        <input type="text" name="nama" value="{{ $user->nama }}" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-1.5 text-xs text-white placeholder-blue-200 focus:outline-none focus:border-white focus:bg-white/20 font-medium transition shadow-inner">
                        @error('nama') <p class="text-red-300 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-[11px] font-medium text-blue-100 block mb-1">Ganti Foto Profil</label>
                        <input type="file" name="foto_profil" class="w-full text-[10px] text-blue-200 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-white/20 file:text-white hover:file:bg-white/30 transition cursor-pointer">
                        @error('foto_profil') <p class="text-red-300 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full bg-white hover:bg-blue-50 text-[#175BAF] font-bold text-xs py-2 rounded-xl transition shadow-md active:scale-[0.98]">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- KONTEN ELEMEN BAWAH (RINGKASAN JADWAL SESI DENGAN BLUR GLASSMORPHISM) --}}
            <div class="relative z-10 space-y-2 mt-8 pt-5 border-t border-white/10 text-white">
                <h4 class="text-[10px] font-bold text-blue-200/70 uppercase tracking-wider mb-2">Ringkasan Sesi</h4>
                
                <div class="flex items-center justify-between bg-white/10 backdrop-blur-sm px-3 py-2 rounded-xl border border-white/5">
                    <span class="text-xs font-light text-blue-100">Total Sesi</span>
                    <span class="text-xs font-bold">{{ $total }}</span>
                </div>

                <div class="flex items-center justify-between bg-white/10 backdrop-blur-sm px-3 py-2 rounded-xl border border-white/5">
                    <span class="text-xs font-light text-blue-100">Sesi Selesai</span>
                    <span class="text-xs font-bold text-green-300">{{ $completed }}</span>
                </div>

                <div class="flex items-center justify-between bg-white/10 backdrop-blur-sm px-3 py-2 rounded-xl border border-white/5">
                    <span class="text-xs font-light text-blue-100">Sesi Berjalan</span>
                    <span class="text-xs font-bold text-amber-300">{{ $ongoing }}</span>
                </div>
            </div>
        </div>

        {{-- ==================== KANAN: LANGSUNG TAB LAYOUT UTAMA ==================== --}}
        <div class="md:col-span-4 w-full flex flex-col justify-start p-6 md:p-10">
            
            {{-- KONDISI NOTIFIKASI SUKSES --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-2 mb-6 w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium text-xs">{{ session('success') }}</span>
                </div>
            @endif

            {{-- JUDUL HALAMAN UTAMA --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Daftar Sesi Bimbingan</h1>
                <p class="text-xs text-gray-400 mt-0.5">Pantau status pendaftaran, riwayat bimbingan, serta jadwal aktif Anda di sini.</p>
            </div>

            {{-- CARD TAB LAYOUT UTAMA --}}
            <div x-data="{ tab: 'ongoing' }" class="bg-white rounded-3xl shadow-md p-6 border border-gray-100 w-full">
                
                {{-- TOMBOL NAVIGASI TABS --}}
                <div class="flex border-b border-gray-100 gap-2 mb-6 overflow-x-auto pb-1">
                    <button @click="tab = 'ongoing'" :class="tab === 'ongoing' ? 'border-[#175BAF] text-[#175BAF] bg-blue-50/50' : 'border-transparent text-gray-400 hover:text-gray-600'" class="px-5 py-2.5 font-bold text-sm border-b-2 transition whitespace-nowrap rounded-t-xl">
                        Ongoing Sessions ({{ $ongoingBookings->count() }})
                    </button>
                    <button @click="tab = 'completed'" :class="tab === 'completed' ? 'border-[#175BAF] text-[#175BAF] bg-blue-50/50' : 'border-transparent text-gray-400 hover:text-gray-600'" class="px-5 py-2.5 font-bold text-sm border-b-2 transition whitespace-nowrap rounded-t-xl">
                        Completed Sessions ({{ $completedBookings->count() }})
                    </button>
                    <button @click="tab = 'cancelled'" :class="tab === 'cancelled' ? 'border-[#175BAF] text-[#175BAF] bg-blue-50/50' : 'border-transparent text-gray-400 hover:text-gray-600'" class="px-5 py-2.5 font-bold text-sm border-b-2 transition whitespace-nowrap rounded-t-xl">
                        Cancelled Sessions ({{ $cancelledBookings->count() }})
                    </button>
                </div>

                {{-- TAB 1: ONGOING --}}
                <div x-show="tab === 'ongoing'" x-transition class="space-y-4">
                    @forelse($ongoingBookings as $booking)
                        <div class="border border-gray-100 bg-gray-50/30 rounded-2xl p-4 flex justify-between items-start hover:border-gray-200 transition">
                            <div class="space-y-1">
                                <h3 class="font-bold text-gray-800 text-base">
                                    {{ $booking->schedule?->mentor?->user?->nama ?? 'Mentor tidak ditemukan' }}
                                </h3>
                                <p class="text-gray-400 text-xs font-medium">
                                    {{ $booking->schedule?->mentor?->kampus?->nama_kampus ?? '-' }}
                                </p>
                                <div class="pt-2 text-xs text-gray-500 font-semibold space-y-0.5">
                                    <p class="text-gray-700">📆 {{ $booking->schedule?->tanggal ? \Carbon\Carbon::parse($booking->schedule->tanggal)->translatedFormat('d M Y') : 'Tanggal tidak tersedia' }}</p>
                                    <p class="text-gray-700">⏰ {{ $booking->schedule?->jam ? \Carbon\Carbon::parse($booking->schedule->jam)->format('H:i') : '-' }} WIB</p>
                                </div>
                                <div class="pt-3">
                                    <form method="POST" action="{{ route('booking.cancel', $booking->id_booking) }}" onsubmit="return confirm('Yakin mau batalkan sesi ini?')">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3.5 py-1.5 rounded-xl text-xs font-bold transition shadow-sm">
                                            Batalkan Sesi
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 font-semibold rounded-full text-xs">
                                Ongoing
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-400 text-sm">
                            🍃 Belum ada sesi bimbingan yang sedang berjalan.
                        </div>
                    @endforelse
                </div>

                {{-- TAB 2: COMPLETED --}}
                <div x-show="tab === 'completed'" x-transition class="space-y-4" style="display: none;">
                    @forelse($completedBookings as $booking)
                        <div class="border border-gray-100 bg-gray-50/30 rounded-2xl p-4 flex justify-between items-center hover:border-gray-200 transition">
                            <div>
                                <h3 class="font-bold text-gray-800">
                                    {{ $booking->schedule?->mentor?->user?->nama ?? 'Mentor tidak ditemukan' }}
                                </h3>
                                <p class="text-xs text-gray-400 mt-0.5 font-medium">
                                    @if($booking->schedule)
                                        {{ \Carbon\Carbon::parse($booking->schedule->tanggal)->translatedFormat('d M Y') }} • {{ \Carbon\Carbon::parse($booking->schedule->jam)->format('H:i') }} WIB
                                    @else
                                        Waktu bimbingan tidak tersedia
                                    @endif
                                </p>
                                <span class="text-green-600 font-semibold text-xs mt-2 inline-block">✓ Selesai bimbingan</span>
                            </div>
                            <div>
                                <a href="{{ route('rating.create', $booking->id_booking) }}" class="inline-block text-xs font-bold px-4 py-2 rounded-xl text-white transition {{ $booking->review ? 'bg-amber-500 hover:bg-amber-600 shadow-sm' : 'bg-[#175BAF] hover:bg-blue-700 shadow-sm' }}">
                                    {{ $booking->review ? 'Update Rating' : 'Beri Rating' }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-400 text-sm">
                            🎓 Belum ada sesi mentoring yang diselesaikan.
                        </div>
                    @endforelse
                </div>

                {{-- TAB 3: CANCELLED --}}
                <div x-show="tab === 'cancelled'" x-transition class="space-y-4" style="display: none;">
                    @forelse($cancelledBookings as $booking)
                        <div class="border border-gray-100 bg-gray-50/30 rounded-2xl p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center hover:border-gray-200 transition gap-4">
                            <div>
                                <h3 class="font-bold text-gray-700">
                                    {{ $booking->schedule?->mentor?->user?->nama ?? 'Mentor tidak ditemukan' }}
                                </h3>
                                <div class="mt-1.5 text-xs text-gray-500 font-medium space-y-0.5">
                                    @if($booking->schedule)
                                        <p class="text-gray-700">📆 {{ \Carbon\Carbon::parse($booking->schedule->tanggal)->translatedFormat('d M Y') }}</p>
                                        <p class="text-gray-700">⏰ {{ \Carbon\Carbon::parse($booking->schedule->jam)->format('H:i') }} WIB</p>
                                    @else
                                        <p class="text-gray-400 italic font-normal">Waktu bimbingan tidak tersedia</p>
                                    @endif
                                </div>
                                <span class="text-red-500 font-semibold text-xs mt-2 inline-block flex items-center gap-1">
                                    ✕ Sesi Dibatalkan
                                </span>
                            </div>
                            
                            <div class="w-full sm:w-auto flex justify-end">
                                <form action="{{ route('profile.cancelled.destroy', $booking->id_booking) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan riwayat pembatalan ini dari tampilan profil?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200/60 px-3.5 py-1.5 rounded-xl text-xs font-bold transition shadow-sm active:scale-95 duration-150">
                                        🗑️ Hapus Riwayat
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-400 text-sm">
                            👍 Tidak ada riwayat sesi belajar yang dibatalkan.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

    </div>
</div>
@endsection