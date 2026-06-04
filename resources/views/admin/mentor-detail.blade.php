@extends('layouts.admin')

@section('content')

<div class="pt-24 max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow p-8">

        <h1 class="text-2xl font-bold mb-6">
            Detail Mentor
        </h1>

        <p>
            <strong>Nama:</strong>
            {{ $mentor->user->nama }}
        </p>

        <p>
            <strong>Email:</strong>
            {{ $mentor->user->email }}
        </p>

        <p>
            <strong>Kampus:</strong>
            {{ $mentor->kampus?->nama_kampus }}
        </p>

        <p>
            <strong>Jurusan:</strong>
            {{ $mentor->jurusan }}
        </p>

        <p>
            <strong>Spesialisasi:</strong>
            {{ $mentor->spesialisasi }}
        </p>

        <p>
            <strong>Biografi:</strong>
            {{ $mentor->biografi }}
        </p>

    </div>

</div>

@endsection