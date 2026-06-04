<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Masuk - MentorCampus</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>

<body>

<div
    class="min-h-screen flex items-center justify-center px-4 bg-cover bg-center relative"
    style="background-image: url('{{ asset('image/wanita-belajar.jpg') }}');">

    {{-- overlay --}}
    <div class="absolute inset-0 bg-black/40"></div>

    <div class="w-full max-w-md relative z-10">

    <div class="w-full max-w-[380px]">

        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-xl p-6">

            <div class="text-center mb-6">
                
            <img src="{{ asset('storage/profile/logo.png') }}" class="h-16 mx-auto mb-4">

                <h2 class="text-xl font-bold">
                    Sign In
                </h2>

                <p class="text-gray-500">
                    continue to your account MentorCampus
                </p>

            </div>

            @if($errors->any())

                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm text-center">

                    {{ $errors->first() }}

                </div>

            @endif

            <form method="POST" action="{{ route('login') }}">

                @csrf

                {{-- EMAIL --}}
                <div class="mb-4">

                    <div class="relative">

                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            placeholder=" "
                            required
                            class="peer w-full border border-gray-300 rounded-xl px-4 pt-5 pb-2 focus:border-[#175BAF] focus:ring-0 outline-none">

                        <label
                            for="email"
                            class="absolute left-4 top-2 text-sm text-gray-500 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-[#175BAF]">

                            email

                        </label>

                    </div>

                </div>

                {{-- PASSWORD --}}
                <div class="mb-4">

                    <div class="relative">

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder=" "
                            required
                            class="peer w-full border border-gray-300 rounded-xl px-4 pt-5 pb-2 focus:border-[#175BAF] focus:ring-0 outline-none">

                        <label
                            for="password"
                            class="absolute left-4 top-2 text-sm text-gray-500 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-[#175BAF]">

                            password

                        </label>

                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">

                            👁

                        </button>

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

                {{-- BUTTON LOGIN --}}
                <button
                    type="submit"
                    class="w-full bg-[#175BAF] text-white py-2.5 rounded-xl font-semibold hover:bg-blue-700 transition">

                    Sign In

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

                    Don't have an account?

                    <a href="{{ route('register') }}"
                       class="text-blue-600 font-bold">

                        Sign Up

                    </a>

                </p>

            </div>

        </div>

    </div>

</div>

<script>
function togglePassword()
{
    const password =
        document.getElementById('password');

    password.type =
        password.type === 'password'
        ? 'text'
        : 'password';
}
</script>

</body>
</html>