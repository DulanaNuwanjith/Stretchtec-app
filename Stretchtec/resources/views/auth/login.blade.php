<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - StretchTec</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-500 to-white">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-4xl bg-white shadow-lg rounded-2xl overflow-hidden flex">
            <!-- Left Panel -->
            <div
                class="w-1/2 bg-gradient-to-br from-blue-500 to-blue-300 text-white flex flex-col justify-center items-center p-8">
                <div class=" items-center rounded-lg mt-6 h-40 mb-32">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-72 object-contain" />
                </div>
                <p class="text-sm text-center font-sans px-4 text-blue-900">
                    Our vision is to be the market leader in service and quality exceeding customer expectations all the
                    time being a partner in progress to win the global market competition in every aspect.
                </p>
            </div>

            <!-- Right Panel -->
            <div class="w-1/2 p-8 flex flex-col justify-center">
                <h2 class="text-2xl font-sans font-bold text-blue-800 mb-2">STRETCHTEC MANAGEMENT SYSTEM</h2>
                <h2 class="text-lg font-sans font-bold text-blue-800 mb-2">(RANGIRI HOLDINGS)</h2>
                <p class="text-sm text-gray-600 mb-6 font-semibold">Login to your account to continue</p>
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus
                        autocomplete="username"
                        class="w-full text-sm font-sans mb-4 px-4 py-2 rounded-full bg-green-100 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    <div class="relative mb-2">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full text-sm font-sans px-4 py-2 pr-10 rounded-full bg-green-100 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-blue-600">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.955 9.955 0 012.188-3.368M6.72 6.72A9.964 9.964 0 0112 5c4.477 0 8.267 2.943 9.541 7a9.966 9.966 0 01-4.292 5.222M15 12a3 3 0 00-4.243-2.828M9.878 9.878a3 3 0 004.243 4.243M3 3l18 18" />
                            </svg>
                        </button>
                    </div>

                    {{-- Show error messages --}}
                    @if ($errors->any())
                        <p class="text-red-500 text-sm mb-4">{{ $errors->first() }}</p>
                    @endif

                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded ml-3 dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm dark:focus:ring-offset-gray-800"
                                name="remember">
                            <span
                                class="ms-2 text-sm text-gray-600 dark:text-gray-400 font-sans">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="text-right text-sm mb-4">
                        @if (Route::has('password.request'))
                            <a class="text-gray-500 hover:text-blue-500 underline font-sans"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                        class="w-full font-sans font-semibold bg-blue-600 text-white py-2 rounded-full hover:bg-blue-700 transition">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
      `;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.955 9.955 0 012.188-3.368M6.72 6.72A9.964 9.964 0 0112 5c4.477 0 8.267 2.943 9.541 7a9.966 9.966 0 01-4.292 5.222M15 12a3 3 0 00-4.243-2.828M9.878 9.878a3 3 0 004.243 4.243M3 3l18 18" />
      `;
        }
    }
</script>
