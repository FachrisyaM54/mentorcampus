@extends('layouts.admin')
@section('content')

<div class="pt-24 max-w-7xl mx-auto">

    <h1 class="text-3xl font-bold mb-8">
        Mentor Management
    </h1>

    <div class="grid md:grid-cols-2 gap-6">

        @forelse($mentors as $mentor)

            <div class="bg-white rounded-2xl shadow p-6">

                <div class="flex items-center gap-4">

                    @if($mentor->user?->foto_profil)

                        <img
                            src="{{ asset($mentor->user->foto_profil) }}"
                            class="w-16 h-16 rounded-full object-cover">

                    @else

                        <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center font-bold">
                            {{ strtoupper(substr($mentor->user->nama,0,1)) }}
                        </div>

                    @endif

                    <div>

                        <h3 class="font-bold text-lg">
                            {{ $mentor->user->nama }}
                        </h3>

                        <p class="text-sm text-gray-500">
                            {{ $mentor->user->email }}
                        </p>

                    </div>

                </div>

                <div class="mt-4 space-y-2 text-sm">

                    <p>
                        <strong>Spesialisasi:</strong>
                        {{ $mentor->spesialisasi ?? '-' }}
                    </p>

                    <p>
                        <strong>Jurusan:</strong>
                        {{ $mentor->jurusan ?? '-' }}
                    </p>

                    <p>
                        <strong>Kampus:</strong>
                        {{ $mentor->kampus?->nama_kampus ?? '-' }}
                    </p>

                </div>

                <a
                    href="{{ route('admin.mentors.detail',$mentor->id_mentor) }}"
                    class="mt-5 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg">

                    Detail

                </a>

                <form
                    action="{{ route('admin.mentors.delete',$mentor->id_mentor) }}"
                    method="POST">

                    @csrf
                    @method('DELETE')

                    <button
                        onclick="return confirm('Hapus mentor ini?')"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg">

                        Hapus

                    </button>

                </form>

            </div>

        @empty

            <p>Belum ada mentor.</p>

        @endforelse

    </div>

</div>

@endsection