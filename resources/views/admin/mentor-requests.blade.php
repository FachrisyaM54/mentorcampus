@extends('layouts.admin')
@section('content')

<div class="pt-28 pb-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4 border-b border-gray-200 pb-5">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Mentor Applications</h1>
            <p class="text-xs text-gray-500 mt-1">Verifikasi berkas, transkrip, dan profil calon mentor sebelum memberikan akses ke platform.</p>
        </div>
        <div class="flex items-center gap-2 text-[11px] font-semibold px-3 py-1.5 bg-amber-50 border border-amber-200 text-amber-700 rounded-lg shadow-sm">
            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-ping"></span>
            {{ $requests->where('status', 'pending')->count() }} Perlu Ditinjau
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all hover:shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 font-medium border-b border-gray-100 text-xs tracking-wider uppercase">
                        <th class="py-4 px-6">Informasi Pemohon</th>
                        <th class="py-4 px-6">Akademik & Jurusan</th>
                        <th class="py-4 px-6 text-center">Status Berkas</th>
                        <th class="py-4 px-6 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-600">
                    @forelse($requests as $request)
                        <tr class="hover:bg-gray-50/40 transition duration-150">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    
                                    {{-- 💡 PERBAIKAN: Membaca foto_profil dari relasi user dan fallback ke inisial huruf --}}
                                    @if(!empty($request->user?->foto_profil) && $request->user->foto_profil != 'default.jpg')
                                        <div class="w-10 h-10 rounded-lg overflow-hidden border border-gray-100 shadow-sm shrink-0">
                                            <img src="{{ asset('storage/' . ltrim($request->user->foto_profil, '/')) }}?t={{ time() }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-tr from-indigo-500 to-indigo-600 flex items-center justify-center text-white font-semibold text-sm border border-white shadow-sm shrink-0">
                                            {{ strtoupper(substr($request->user->nama ?? 'M', 0, 1)) }}
                                        </div>
                                    @endif

                                    <div>
                                        <h3 class="font-semibold text-gray-800 text-sm tracking-wide">{{ $request->user->nama ?? 'Nama Tidak Terdeteksi' }}</h3>
                                        <p class="text-xs text-gray-400 font-normal">{{ $request->user->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <p class="font-medium text-gray-700 text-sm tracking-wide">{{ $request->jurusan }}</p>
                                <p class="text-xs text-gray-400 font-normal mt-0.5">Fakultas {{ $request->fakultas ?? 'N/A' }}</p>
                            </td>

                            <td class="py-4 px-6 text-center">
                                <span class="text-[11px] font-medium px-2.5 py-0.5 rounded-md border tracking-wide inline-block
                                    {{ $request->status == 'accepted' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : ($request->status == 'pending' ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-red-50 text-red-600 border-red-100') }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-center">
                                <button type="button" 
                                    onclick="openModalDetail('{{ json_encode([
                                        'id' => $request->id_calon,
                                        'nama' => $request->user->nama,
                                        'email' => $request->user->email,
                                        'usia' => $request->usia ?? '-',
                                        'fakultas' => $request->fakultas,
                                        'jurusan' => $request->jurusan,
                                        'spesialisasi' => $request->spesialisasi ?? 'Umum',
                                        'biografi' => $request->biografi ?? 'Tidak mengisi biografi.',
                                        'transkrip' => $request->file_transkrip ? asset('storage/' . $request->file_transkrip) : null,
                                        'status' => $request->status,
                                        'approve_url' => route('admin.mentor.approve', $request->id_calon),
                                        'reject_url' => route('admin.mentor.reject', $request->id_calon)
                                    ]) }}')"
                                    class="inline-flex items-center gap-1.5 bg-white border border-gray-200 hover:border-indigo-400 hover:text-indigo-600 font-medium px-3 py-1.5 rounded-lg text-xs text-gray-600 shadow-sm transition cursor-pointer">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Berkas
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span class="text-sm font-medium text-gray-400">Belum ada pengajuan mentor masuk.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalDetail" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4 transition-all duration-300">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-xl border border-gray-100 overflow-hidden transform scale-100 transition-all">
        
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <div>
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">Detail Aplikasi Pelamar</h3>
                <p class="text-xs text-gray-400 mt-0.5 font-normal">Periksa kecocokan data akademik dan keaslian berkas pelamar.</p>
            </div>
            <button onclick="closeModalDetail()" class="text-gray-400 hover:text-gray-600 transition bg-gray-50 p-1.5 rounded-lg cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-6 max-h-[65vh] overflow-y-auto space-y-5 text-sm text-gray-600">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-gray-50/70 p-4 rounded-lg border border-gray-100">
                <div>
                    <span class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Nama Lengkap</span>
                    <span id="detNama" class="text-sm font-semibold text-gray-800 mt-0.5 block">-</span>
                </div>
                <div>
                    <span class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Kontak Email</span>
                    <span id="detEmail" class="text-xs font-normal text-gray-500 mt-0.5 block truncate">-</span>
                </div>
                <div>
                    <span class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Usia</span>
                    <span id="detUsia" class="text-sm font-semibold text-gray-800 mt-0.5 block">-</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Fakultas & Jurusan</label>
                    <div class="p-3 bg-white border border-gray-100 rounded-lg text-xs font-medium text-gray-700" id="detAkademik">-</div>
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Spesialisasi Keahlian</label>
                    <div class="p-3 bg-indigo-50/50 text-indigo-700 rounded-lg text-xs font-medium border border-indigo-100/50" id="detSpesialisasi">-</div>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Biografi & Deskripsi Diri</label>
                <div class="p-4 bg-gray-50/50 border border-gray-100 rounded-lg text-xs text-gray-500 leading-relaxed font-normal whitespace-pre-line" id="detBiografi">
                    -
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Dokumen Pendukung (Transkrip Nilai / CV)</label>
                <div id="wrapperTranskrip" class="hidden">
                    <a id="detTranskripLink" href="#" target="_blank" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium text-xs bg-indigo-50/70 hover:bg-indigo-100/80 px-4 py-2.5 rounded-lg border border-indigo-100/40 transition w-full sm:w-auto">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Buka Dokumen Transkrip
                    </a>
                </div>
                <p id="detNoTranskrip" class="text-xs text-gray-400 italic font-normal hidden">Pelamar tidak melampirkan dokumen fisik.</p>
            </div>
        </div>

        <div class="p-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">
                Status: <span id="detStatusBadge" class="ml-1 px-2 py-0.5 rounded font-medium border">Pending</span>
            </div>
            
            <div id="actionContainer" class="flex items-center gap-2 justify-end">
                <form id="formReject" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-white border border-gray-200 hover:bg-red-50 hover:text-red-600 text-gray-600 font-medium text-xs px-4 py-2 rounded-lg transition cursor-pointer" onclick="return confirm('Tolak permohonan ini?')">
                        Tolak
                    </button>
                </form>

                <form id="formApprove" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-xs px-4 py-2 rounded-lg shadow-sm transition cursor-pointer">
                        Terima Mentor
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
function openModalDetail(jsonData) {
    const data = JSON.parse(jsonData);
    
    document.getElementById('detNama').innerText = data.nama;
    document.getElementById('detEmail').innerText = data.email;
    document.getElementById('detUsia').innerText = data.usia + ' Tahun';
    document.getElementById('detAkademik').innerText = data.jurusan + ' (Fakultas ' + data.fakultas + ')';
    document.getElementById('detSpesialisasi').innerText = data.spesialisasi;
    document.getElementById('detBiografi').innerText = data.biografi;

    const badge = document.getElementById('detStatusBadge');
    badge.innerText = data.status.toUpperCase();
    if(data.status === 'accepted') {
        badge.className = "ml-1 px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100";
    } else if(data.status === 'pending') {
        badge.className = "ml-1 px-2 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-600 border border-amber-100";
    } else {
        badge.className = "ml-1 px-2 py-0.5 rounded text-[10px] font-medium bg-red-50 text-red-600 border border-red-100";
    }

    if (data.transkrip) {
        document.getElementById('wrapperTranskrip').classList.remove('hidden');
        document.getElementById('detNoTranskrip').classList.add('hidden');
        document.getElementById('detTranskripLink').href = data.transkrip;
    } else {
        document.getElementById('wrapperTranskrip').classList.add('hidden');
        document.getElementById('detNoTranskrip').classList.remove('hidden');
    }

    if (data.status === 'pending') {
        document.getElementById('actionContainer').classList.remove('hidden');
        document.getElementById('formApprove').action = data.approve_url;
        document.getElementById('formReject').action = data.reject_url;
    } else {
        document.getElementById('actionContainer').classList.add('hidden');
    }

    document.getElementById('modalDetail').classList.remove('hidden');
}

function closeModalDetail() {
    document.getElementById('modalDetail').classList.add('hidden');
}
</script>
@endsection