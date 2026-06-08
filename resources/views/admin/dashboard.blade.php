@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
    $campuses = \App\Models\Kampus::all();
@endphp

<div class="pt-28 pb-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4 border-b border-gray-200 pb-5">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Admin Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Selamat datang kembali! Pantau metrik pertumbuhan dan kelola integrasi kampus mitra di sini.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <button onclick="document.getElementById('modalKampus').classList.remove('hidden')" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2.5 rounded-xl shadow-sm transition duration-150 ease-in-out text-sm cursor-pointer">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kampus Mitra
            </button>
            <a href="{{ route('admin.report.pdf') }}" class="inline-flex items-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold px-4 py-2.5 rounded-xl shadow-sm transition duration-150 ease-in-out text-sm">
                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export PDF Report
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 transition-all hover:shadow-md">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Kampus Mitra Terdaftar</h2>
                <p class="text-xs text-gray-500 mt-0.5">List kampus resmi yang terintegrasi di filter course student & form pendaftaran mentor.</p>
            </div>
            <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full border border-indigo-100">
                {{ $campuses->count() }} Kampus Aktif
            </span>
        </div>
        
        <div class="overflow-x-auto rounded-xl border border-gray-100">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 font-semibold border-b border-gray-100">
                        <th class="py-3.5 px-5 w-20 text-center">No</th>
                        <th class="py-3.5 px-5">Nama Institusi / Universitas</th>
                        <th class="py-3.5 px-5 text-center w-40">Aksi Administrasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($campuses as $key => $kampus)
                        <tr class="hover:bg-gray-50/60 transition duration-150">
                            <td class="py-3.5 px-5 text-center text-gray-400 font-medium bg-gray-50/30">{{ $key + 1 }}</td>
                            <td class="py-3.5 px-5 font-semibold text-gray-800 tracking-wide">{{ $kampus->nama_kampus }}</td>
                            <td class="py-3.5 px-5 text-center">
                                <form action="{{ route('admin.kampus.delete', $kampus->id_kampus) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kampus {{ $kampus->nama_kampus }} dari sistem?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold inline-flex items-center gap-1.5 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus Mitra
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    <span class="text-base font-medium">Belum ada data kampus mitra terdaftar.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition duration-200">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total User</p>
                <h2 class="text-3xl font-black text-gray-900 mt-1 tracking-tight">{{ $totalUser }}</h2>
            </div>
            <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition duration-200">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Mentor</p>
                <h2 class="text-3xl font-black text-gray-900 mt-1 tracking-tight">{{ $totalMentor }}</h2>
            </div>
            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition duration-200">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Sessions</p>
                <h2 class="text-3xl font-black text-gray-900 mt-1 tracking-tight">{{ $totalBooking }}</h2>
            </div>
            <div class="p-3.5 bg-purple-50 text-purple-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition duration-200">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pending Request</p>
                <h2 class="text-3xl font-black text-amber-500 mt-1 tracking-tight">{{ $pendingMentor }}</h2>
            </div>
            <div class="p-3.5 bg-amber-50 text-amber-500 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <h2 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-50 pb-2">
                <span class="w-3 h-3 bg-indigo-500 rounded-full animate-pulse"></span> Distribusi Peran Pengguna
            </h2>
            <div class="max-h-64 flex justify-center p-2">
                <canvas id="userChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <h2 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-50 pb-2">
                <span class="w-3 h-3 bg-purple-500 rounded-full animate-pulse"></span> Status Sesi Konsultasi
            </h2>
            <div class="max-h-64 flex justify-center p-2">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 hover:shadow-md transition">
        <h2 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-50 pb-2">
            <span class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></span> Grafik Pertumbuhan Booking per Bulan
        </h2>
        <canvas id="bookingChart" class="max-h-72"></canvas>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4 border-b border-gray-50 pb-3">
            <div>
                <h2 class="text-base font-bold text-gray-900">Log Aktivitas Transaksi Terkini</h2>
                <p class="text-xs text-gray-400 mt-0.5">Real-time update pendaftaran mahasiswa ke jadwal bimbingan.</p>
            </div>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($latestBookings as $booking)
                <div class="py-3.5 flex items-center justify-between hover:bg-gray-50/70 px-3 rounded-xl transition">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center font-black text-white text-sm shadow-sm">
                            {{ strtoupper(substr($booking->student?->nama ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm tracking-wide">{{ $booking->student?->nama ?? 'User Tanpa Nama' }}</p>
                            <p class="text-xs text-gray-400">Kode Booking Sesi: <span class="font-mono text-gray-500">#BK-{{ $booking->id }}</span></p>
                        </div>
                    </div>
                    <div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full border
                            {{ $booking->status == 'Completed' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($booking->status == 'Ongoing' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'bg-red-50 text-red-700 border-red-200') }}">
                            {{ $booking->status }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-center text-sm text-gray-400 py-6">Belum ada aktivitas transaksi konsultasi terbaru.</p>
            @endforelse
        </div>
    </div>
</div>

<div id="modalKampus" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4 transition-all duration-300">
    <div class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-md border border-gray-100 transform scale-100 transition-all">
        <div class="flex items-center justify-between mb-5 border-b border-gray-100 pb-3">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Daftarkan Mitra Baru</h3>
                <p class="text-xs text-gray-400 mt-0.5">Sistem otomatis meregenerasi id_kampus ke database.</p>
            </div>
            <button onclick="document.getElementById('modalKampus').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition bg-gray-50 hover:bg-gray-100 p-1.5 rounded-lg cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.kampus.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-gray-700 text-xs font-bold uppercase tracking-wider mb-2">Nama Resmi Universitas / Kampus</label>
                <input type="text" name="nama_kampus" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition font-medium text-gray-800 placeholder-gray-300 shadow-sm" placeholder="Contoh: Universitas Airlangga" required>
            </div>
            <div class="flex justify-end gap-2.5">
                <button type="button" onclick="document.getElementById('modalKampus').classList.add('hidden')" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-bold px-4 py-2.5 rounded-xl transition cursor-pointer">Batal</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-sm transition cursor-pointer">Simpan Mitra Resmi</button>
            </div>
        </form>
    </div>
</div>

<script>
// CHART KODE (Menggunakan tema palet warna moderen Pastel Tech)
const userChart = new Chart(document.getElementById('userChart'), {
    type: 'pie',
    data: {
        labels: ['Student', 'Mentor', 'Admin'],
        datasets: [{
            data: [{{ $studentCount }}, {{ $mentorCount }}, {{ $adminCount }}],
            backgroundColor: ['#6366f1', '#10b981', '#f59e0b'],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});

const statusChart = new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Completed', 'Ongoing', 'Cancelled'],
        datasets: [{
            data: [{{ $completedBooking }}, {{ $ongoingBooking }}, {{ $cancelledBooking }}],
            backgroundColor: ['#10b981', '#6366f1', '#ef4444'],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },
    options: { responsive: true, cutout: '70%', plugins: { legend: { position: 'bottom' } } }
});

const bookingChart = new Chart(document.getElementById('bookingChart'), {
    type: 'bar',
    data: {
        labels: [
            @foreach($bookingPerMonth as $item)
                'Bulan {{ $item->month }}',
            @endforeach
        ],
        datasets: [{
            label: 'Jumlah Booking Sesi',
            data: [
                @foreach($bookingPerMonth as $item)
                    {{ $item->total }},
                @endforeach
            ],
            backgroundColor: 'rgba(99, 102, 241, 0.85)',
            hoverBackgroundColor: '#4f46e5',
            borderRadius: 8,
            borderSkipped: false
        }]
    },
    options: { 
        responsive: true, 
        scales: { 
            y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
            x: { grid: { display: false } }
        } 
    }
});
</script>
@endsection