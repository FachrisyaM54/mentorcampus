@extends('layouts.app')
@section('content')

<div class="pt-24">

    <div class="max-w-xl mx-auto bg-white p-6 rounded-2xl shadow">

        <h1 class="text-2xl font-bold mb-6">
            Tambah Jadwal
        </h1>

        <form method="POST"
              action="{{ route('mentor.schedule.store') }}">

            @csrf

            <div class="mb-4">

                <label>Tanggal</label>

                <input type="date"
                       name="tanggal"
                       class="w-full border p-2 rounded"
                       required>

            </div>

            <div class="mb-4">

                <label>Jam</label>

                <input type="time"
                       name="jam"
                       class="w-full border p-2 rounded"
                       required>

            </div>

            <div class="mb-4">

                <label>Harga</label>

                <input type="number"
                       name="harga"
                       class="w-full border p-2 rounded"
                       required>

            </div>

            <button
                class="bg-blue-600 text-white px-4 py-2 rounded">

                Simpan Jadwal

            </button>

        </form>

    </div>

</div>

@endsection