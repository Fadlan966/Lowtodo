<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lowTodo | Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'theme-bg': '#1a1a1e',
                        'theme-card': '#252529',
                        'theme-input': '#323237',
                        'theme-accent': '#3b82f6',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&display=swap" rel="stylesheet">
</head>

<body class="flex justify-center items-center min-h-screen bg-theme-bg p-4 font-[League_Spartan]">
    <div class="bg-theme-card p-8 shadow-xl rounded-xl w-full max-w-md text-white border border-gray-800">
        <!-- Header with logo -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-500">
                Reset Password
            </h2>
            <div class="bg-theme-input p-2 rounded-lg">
                <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/ab3a8b29f00131f346e3e282b409215d63484f09"
                    alt="Logo" class="h-8">
            </div>
        </div>

        @if (Session::has('message'))
            <div class="bg-green-500/20 border border-green-500 text-green-100 text-sm p-3 rounded-lg flex items-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-300" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ Session::get('message') }}
            </div>
        @endif

        <form action="{{ route('reset.password.post') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div>
                <label for="email_address" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>
                    <input type="email" id="email_address" name="email" required autofocus
                        placeholder="name@example.com"
                        class="w-full pl-10 p-3 border border-gray-700 rounded-lg bg-theme-input text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @if ($errors->has('email')) border-red-500 @endif">
                </div>
                @if ($errors->has('email'))
                    <span class="text-red-400 text-sm mt-1 block">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">New Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" required
                        placeholder="••••••••••"
                        class="w-full pl-10 p-3 border border-gray-700 rounded-lg bg-theme-input text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @if ($errors->has('password')) border-red-500 @endif">
                    <button type="button" onclick="togglePassword('password', 'password-icon')" class="absolute right-3 top-3 text-gray-400 hover:text-gray-200 transition">
                        <svg id="password-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51
                                7.36 4.5 12 4.5c4.638 0 8.573 3.007
                                9.963 7.178.07.207.07.431 0
                                .639C20.577 16.49 16.64 19.5 12
                                19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                </div>
                @if ($errors->has('password'))
                    <span class="text-red-400 text-sm mt-1 block">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password-confirm" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="password" id="password-confirm" name="password_confirmation" required
                        placeholder="••••••••••"
                        class="w-full pl-10 p-3 border border-gray-700 rounded-lg bg-theme-input text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @if ($errors->has('password_confirmation')) border-red-500 @endif">
                    <button type="button" onclick="togglePassword('password-confirm', 'confirm-password-icon')" class="absolute right-3 top-3 text-gray-400 hover:text-gray-200 transition">
                        <svg id="confirm-password-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51
                                7.36 4.5 12 4.5c4.638 0 8.573 3.007
                                9.963 7.178.07.207.07.431 0
                                .639C20.577 16.49 16.64 19.5 12
                                19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                </div>
                @if ($errors->has('password_confirmation'))
                    <span class="text-red-400 text-sm mt-1 block">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <!-- Button Reset Password -->
            <button type="submit"
                class="w-full bg-theme-accent text-white py-3 rounded-lg hover:bg-blue-500 transition duration-200 font-medium flex justify-center items-center mt-8">
                <span>Reset Password</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                </svg>
            </button>
        </form>

        <!-- Back to Login Link -->
        <div class="mt-8 text-center">
            <p class="text-gray-300">
                <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium transition flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Login
                </a>
            </p>
        </div>

        <!-- Footer -->
        <div class="mt-8 pt-4 border-t border-gray-800 text-center text-gray-500 text-xs">
            <p>© 2025 lowTodo. All rights reserved.</p>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0
                        0 1.934 12C3.226 16.338 7.244
                        19.5 12 19.5c.993 0 1.953-.138
                        2.863-.395M6.228 6.228A10.451
                        10.451 0 0 1 12 4.5c4.756 0
                        8.773 3.162 10.065 7.498a10.522
                        10.522 0 0 1-4.293 5.774M6.228
                        6.228 3 3m3.228 3.228 3.65
                        3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0
                        0a3 3 0 1 0-4.243-4.243m4.242
                        4.242L9.88 9.88" />
                `;
            } else {
                input.type = "password";
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51
                        7.36 4.5 12 4.5c4.638 0 8.573 3.007
                        9.963 7.178.07.207.07.431 0
                        .639C20.577 16.49 16.64 19.5 12
                        19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                `;
            }
        }
    </script>
</body>

</html>
