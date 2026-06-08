<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- ==================== BOX 1: UPDATE PROFILE INFORMATION & FOTO PROFIL ==================== --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Profile Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Update your account's profile information, email address, and profile picture.") }}
                            </p>
                        </header>

                        {{-- Form Mengarah ke Profile Update dengan Dukungan Upload File --}}
                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            {{-- INPUT FOTO PROFIL --}}
                            <div>
                                <x-input-label for="foto_profil" :value="__('Profile Picture')" />
                                
                                <div class="flex items-center gap-4 mt-2">
                                    {{-- Container Preview Foto --}}
                                    <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-100 border border-gray-200 flex items-center justify-center shadow-sm">
                                        @if($user->foto_profil)
                                            <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-[#175BAF] flex items-center justify-center text-xl font-bold text-white uppercase">
                                                {{ substr($user->nama, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Tombol Browse File --}}
                                    <div class="flex-1">
                                        <input id="foto_profil" name="foto_profil" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#175BAF] hover:file:bg-blue-100 transition cursor-pointer" />
                                        <x-input-error class="mt-2" :messages="$errors->get('foto_profil')" />
                                    </div>
                                </div>
                            </div>

                            {{-- INPUT NAMA --}}
                            <div>
                                <x-input-label for="nama" :value="__('Name')" />
                                <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $user->nama)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                            </div>

                            {{-- INPUT EMAIL --}}
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            {{-- TOMBOL SUBMIT --}}
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                                        {{ __('Saved.') }}
                                    </p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            {{-- ==================== BOX 2: UPDATE PASSWORD ==================== --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- ==================== BOX 3: DELETE ACCOUNT ==================== --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>