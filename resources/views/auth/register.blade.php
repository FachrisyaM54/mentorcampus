<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Masuk - MentorCampus</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<div
    class="min-h-screen flex items-center justify-center px-4 bg-cover bg-center relative"
    style="background-image:url('{{ asset('image/wanita-belajar.jpg') }}')">

    <div class="absolute inset-0 bg-black/45"></div>

    <div class="relative z-10 w-full max-w-md">

        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-xl p-6">

            <div class="text-center mb-6">
                
            <img src="{{ asset('storage/profile/logo.png') }}" class="h-16 mx-auto mb-4">

                <h2 class="text-xl font-bold">
                    Sign Up
                </h2>

            </div>

            @if($errors->any())

                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm text-center">

                    {{ $errors->first() }}

                </div>

            @endif

            <form method="POST" action="{{ route('register') }}">

                @csrf

                {{-- NAMA --}}
                <div class="mb-4">

                    <div class="relative">

                        <input
                            type="text"
                            name="nama"
                            value="{{ old('nama') }}"
                            placeholder="Full Name"
                            class="w-full border rounded-xl px-4 py-3">

                    </div>

                </div>

                {{-- EMAIL --}}
                <div class="mb-4">

                    <div class="relative">

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Email"
                            class="w-full border rounded-xl px-4 py-3">

                    </div>

                </div>

                {{-- PASSWORD --}}
                <div class="mb-4">
    <div class="relative">

        <input
            id="password"
            type="password"
            name="password"
            placeholder="Password"
            class="w-full border rounded-xl px-4 py-3 pr-12">

        <button
            type="button"
            onclick="togglePassword('password')"
            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#175BAF]">

            👁

        </button>

    </div>
</div>

                <div class="mb-4">
    <div class="relative">

        <input
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            placeholder="Repeat Password"
            class="w-full border rounded-xl px-4 py-3 pr-12">

        <button
            type="button"
            onclick="togglePassword('password_confirmation')"
            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#175BAF]">

            👁

        </button>

    </div>
</div>

                <div class="mb-4">
                    <div class="relative">
<div class="grid grid-cols-2 gap-4">

    <select
        name="gender"
        class="border rounded-xl px-4 py-3">

        <option value="">
            Gender
        </option>

        <option value="male">
            Male
        </option>

        <option value="female">
            Female
        </option>

    </select>

    <select
        name="semester"
        class="border rounded-xl px-4 py-3">

        <option value="">
            Semester
        </option>

        @for($i=1;$i<=14;$i++)

            <option value="{{ $i }}">
                Semester {{ $i }}
            </option>

        @endfor

    </select>

</div>
                    </div>
                </div>

                {{-- OPTION --}}
                <div class="flex justify-between items-center mb-6">

                    <label class="flex items-center gap-2 text-sm">

                        <input
                            type="checkbox"
                            name="remember">

                        Remember me

                    </label>

                    @if(Route::has('password.request'))

                        <a href="{{ route('password.request') }}"
                           class="text-blue-600 text-sm">

                            Forgot Password?

                        </a>

                    @endif

                </div>

                {{-- BUTTON SIGN UP --}}
                <button
                    type="submit"
                    class="w-full mt-5 bg-[#175BAF] text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition">

                    Sign Up

                </button>

            </form>

            {{-- DIVIDER --}}
            <div class="flex items-center my-6">

                <div class="flex-1 border-t"></div>

                <span class="px-4 text-gray-400 text-sm">
                    or continue with
                </span>

                <div class="flex-1 border-t"></div>

            </div>

            {{-- SOCIAL --}}
            <div class="grid grid-cols-2 gap-3">

                <button
                    type="button"
                    class="border rounded-xl py-3 text-sm font-medium hover:bg-gray-50">

                    Google

                </button>

                <button
                    type="button"
                    class="border rounded-xl py-3 text-sm font-medium hover:bg-gray-50">

                    Github

                </button>

            </div>

            {{-- SIGNUP --}}
            <div class="text-center mt-8">

                <p class="text-gray-500">

                    Do you have account?

                    <a href="{{ route('login') }}"
                       class="text-blue-600 font-bold">

                        Sign In

                    </a>

                </p>

            </div>

        </div>

    </div>

</div>

<script>
function togglePassword(id)
{
    const input = document.getElementById(id);

    input.type =
        input.type === 'password'
            ? 'text'
            : 'password';
}
</script>

</body>
</html>