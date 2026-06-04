@extends('layouts.admin')
@section('content')

<div class="pt-24">

    <div class="max-w-6xl mx-auto">

        <div class="bg-white rounded-2xl shadow overflow-hidden">

            <div class="p-6 border-b">

                <h2 class="text-xl font-bold text-[#175BAF]">
                    User List
                </h2>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-3 text-left">
                                User
                            </th>

                            <th class="px-6 py-3 text-left">
                                Gender
                            </th>

                            <th class="px-6 py-3 text-left">
                                Semester
                            </th>

                            <th class="px-6 py-3 text-left">
                                Role
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($users as $user)

                        <tr class="border-b">

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    @if($user->foto_profil)

                                        <img
                                            src="{{ asset('storage/'.$user->foto_profil) }}"
                                            class="w-10 h-10 rounded-full object-cover">

                                    @else

                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold">

                                            {{ strtoupper(substr($user->nama,0,1)) }}

                                        </div>

                                    @endif

                                    <div>

                                        <p class="font-semibold">
                                            {{ $user->nama }}
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            {{ $user->email }}
                                        </p>

                                    </div>

                                </div>

                            </td>

                            <td class="px-6 py-4">
                                {{ ucfirst($user->gender ?? '-') }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $user->semester ?? '-' }}
                            </td>

                            <td class="px-6 py-4">

                                <span class="px-3 py-1 rounded-full text-xs bg-gray-100">

                                    {{ $user->roleData?->nama_role ?? '-' }}

                                </span>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection