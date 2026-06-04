@extends('layouts.app')
@section('content')

<div class="pt-5">

    <div class="pt-24 max-w-4xl mx-auto">

        <div class="bg-white rounded-2xl shadow p-8">

            <h1 class="text-2xl font-bold mb-6">
                Become Mentor
            </h1>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <p>
                Nama:
                {{ $user->nama }}
            </p>

            <p>
                Email:
                {{ $user->email }}
            </p>

            <hr class="my-6">

            @if($pendaftaran)

                <div class="p-4 rounded-lg bg-yellow-50">

                    Status:
                    <strong>
                        {{ ucfirst($pendaftaran->status) }}
                    </strong>

                </div>

            @else

            <form method="POST"
                action="{{ route('mentor.store') }}"
                enctype="multipart/form-data"
                class="space-y-5">

                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Campus
                    </label>

                    <select name="kampus"
                            required
                            class="w-full border rounded-lg p-3">

                        <option value="">
                            Pilih Kampus
                        </option>

                        @foreach($kampus as $k)
                            <option value="{{ $k->id_kampus }}">
                                {{ $k->nama_kampus }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Fakultas
                    </label>

                    <input type="text"
                        name="fakultas"
                        required
                        class="w-full border rounded-lg p-3">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Jurusan
                    </label>

                    <input type="text"
                        name="jurusan"
                        required
                        class="w-full border rounded-lg p-3">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Usia
                    </label>

                    <input type="number"
                        name="usia"
                        min="17"
                        max="40"
                        required
                        class="w-full border rounded-lg p-3">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Spesialisasi
                    </label>

                    <input type="text"
                        name="spesialisasi"
                        required
                        class="w-full border rounded-lg p-3">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Biografi
                    </label>

                    <textarea name="biografi"
                            rows="4"
                            class="w-full border rounded-lg p-3"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Upload Transkrip (PDF)
                    </label>

                    <input type="file"
                        name="transkrip"
                        accept=".pdf"
                        required
                        class="w-full border rounded-lg p-3">
                </div>

                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg">

                    Submit Mentor

                </button>

            </form>

            @endif

        </div>

    </div>

</div>
@endsection