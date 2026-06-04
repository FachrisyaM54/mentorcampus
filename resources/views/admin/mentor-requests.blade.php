@extends('layouts.admin')
@section('content')

<div class="pt-5">
    <div class="pt-24 max-w-6xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">
            Mentor Applications
        </h1>

        <table class="w-full bg-white shadow rounded-xl">

            <thead>
                <tr class="border-b">
                    <th class="p-3">Nama</th>
                    <th class="p-3">Jurusan</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach($requests as $request)

                <tr class="border-b">

                    <td class="p-3">
                        {{ $request->user->nama }}
                    </td>

                    <td class="p-3">
                        {{ $request->jurusan }}
                    </td>

                    <td class="p-3">
                        {{ $request->status }}
                    </td>

                    <td class="p-3">

                    @if($request->status == 'pending')

                        <form action="{{ route('admin.mentor.approve',$request->id_calon) }}"
                            method="POST"
                            class="inline">
                            @csrf

                            <button
                                class="bg-green-500 text-white px-3 py-1 rounded">
                                Approve
                            </button>
                        </form>

                        <form action="{{ route('admin.mentor.reject',$request->id_calon) }}"
                            method="POST"
                            class="inline">
                            @csrf

                            <button
                                class="bg-red-500 text-white px-3 py-1 rounded">
                                Reject
                            </button>
                        </form>

                    @endif

                </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>
@endsection