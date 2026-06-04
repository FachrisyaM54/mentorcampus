@extends('layouts.app')

@section('content')
<div class="pt-5">

    <div class="pt-24">

        <div class="max-w-3xl mx-auto">

            <div class="bg-white rounded-2xl shadow p-8">

                <h1 class="text-2xl font-bold text-blue-600 mb-2">
                    Mentor Application Status
                </h1>

                <p class="text-gray-500 mb-8">
                    Track your mentor registration status
                </p>

                <h2 class="font-semibold mb-4">
                    Hello, {{ $user->nama }} 👋
                </h2>

                @if(!$pendaftaran)

                    <div class="bg-gray-100 p-4 rounded-xl">
                        You haven't applied yet.
                    </div>

                @elseif($pendaftaran->status == 'pending')

                    <div class="bg-yellow-100 text-yellow-700 p-4 rounded-xl">
                        ⏳ Your application is being reviewed
                    </div>

                @elseif($pendaftaran->status == 'accepted')

                    <div class="bg-green-100 text-green-700 p-4 rounded-xl">
                        🎉 Congratulations! You are now a mentor
                    </div>

                @elseif($pendaftaran->status == 'rejected')

                    <div class="bg-red-100 text-red-700 p-4 rounded-xl">
                        ❌ Sorry, your application was rejected
                    </div>

                @endif

                <div class="mt-6 border-t pt-6">

                    <div class="flex justify-between mb-3">
                        <span>Status</span>

                        <span class="font-semibold">
                            {{ $pendaftaran->status ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span>Submitted At</span>

                        <span>
                            {{ $pendaftaran->created_at ?? '-' }}
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection