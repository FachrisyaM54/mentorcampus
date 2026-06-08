<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Masuk - MentorCampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased">

<!-- py-10 md:py-20 memastikan card punya space bernapas dan tidak nempel atas bawah -->
<div class="min-h-screen flex items-center justify-center px-4 py-10 md:py-20 bg-cover bg-center relative"
     style="background-image: url('{{ asset('image/wanita-belajar.jpg') }}');">

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="w-full max-w-[365px] relative z-10 my-auto">
        <div class="bg-white/10 backdrop-blur-xl rounded-xl shadow-2xl p-6 border border-white/20">

            {{-- Header --}}
            <div class="text-center mb-6">
                <img src="{{ asset('storage/profile/logo.png') }}" class="h-10 mx-auto mb-3" alt="Logo">
                <h2 class="text-xl font-bold text-white tracking-tight">Sign In</h2>
                <p class="text-xs text-gray-300 mt-1">continue to your account MentorCampus</p>
            </div>

            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500/40 text-red-200 px-3 py-2 rounded-lg mb-4 text-xs text-center backdrop-blur-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- EMAIL --}}
                <div class="mb-4">
                    <label for="email" class="block text-xs font-semibold text-gray-200 mb-1.5 uppercase tracking-wider">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full bg-transparent border border-gray-400 rounded-lg px-3.5 py-2.5 text-white text-sm outline-none focus:border-[#175BAF] focus:ring-1 focus:ring-[#175BAF] transition-all placeholder-gray-400"
                           placeholder="name@example.com">
                </div>

                {{-- PASSWORD --}}
                <div class="mb-4">
                    <label for="password" class="block text-xs font-semibold text-gray-200 mb-1.5 uppercase tracking-wider">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                               class="w-full bg-transparent border border-gray-400 rounded-lg px-3.5 py-2.5 text-white text-sm outline-none focus:border-[#175BAF] focus:ring-1 focus:ring-[#175BAF] transition-all placeholder-gray-400"
                               placeholder="••••••••">
                        <button type="button" onclick="togglePassword('password', this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-300 hover:text-white transition text-sm select-none outline-none">
                            👁️
                        </button>
                    </div>
                </div>

                {{-- OPTIONS --}}
                <div class="flex justify-between items-center mb-5">
                    <label class="flex items-center gap-1.5 text-xs text-gray-200 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="rounded border-gray-400 bg-transparent text-[#175BAF] focus:ring-0">
                        Remember me
                    </label>

                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-blue-400 hover:text-blue-300 hover:underline text-xs font-medium">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full bg-[#175BAF] text-white py-2.5 rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-900/30 active:scale-[0.99]">
                    Sign In
                </button>
            </form>

            {{-- DIVIDER --}}
            <div class="flex items-center my-5">
                <div class="flex-1 border-t border-white/10"></div>
                <span class="px-3 text-gray-400 text-[11px] uppercase tracking-widest font-medium">or continue with</span>
                <div class="flex-1 border-t border-white/10"></div>
            </div>

            {{-- SOCIAL LOGOS --}}
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ url('auth/google') }}" class="flex items-center justify-center border border-white/20 bg-white/10 backdrop-blur-sm rounded-lg py-2.5 hover:bg-white/20 active:scale-[0.98] transition shadow-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.53-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-8.72z"/>
                        <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.11 0-5.74-2.11-6.68-4.96H1.21v3.15C3.18 21.88 7.31 24 12 24z"/>
                        <path fill="#FBBC05" d="M5.32 14.24A7.16 7.16 0 0 1 4.91 12c0-.79.13-1.57.38-2.31V6.54H1.21A11.94 11.94 0 0 0 0 12c0 1.92.45 3.74 1.21 5.46l4.11-3.22z"/>
                        <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.18 2.12 1.21 5.39l4.11 3.22c.94-2.85 3.57-4.86 6.68-4.86z"/>
                    </svg>
                </a>
                <a href="{{ url('auth/github') }}" class="flex items-center justify-center border border-white/20 bg-white/10 backdrop-blur-sm rounded-lg py-2.5 hover:bg-white/20 active:scale-[0.98] transition shadow-sm">
                    <svg class="w-5 h-5" fill="white" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.483 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.464-1.11-1.464-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.579.688.481C19.137 20.162 22 16.418 22 12c0-5.523-4.477-10-10-10z"/>
                    </svg>
                </a>
            </div>

            <div class="text-center mt-5">
                <p class="text-xs text-gray-300">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 hover:underline font-bold ml-1">Sign Up</a>
                </p>
            </div>

        </div>
    </div>
</div>

<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
    } else {
        input.type = 'password';
        btn.textContent = '👁️';
    }
}
</script>

</body>
</html>