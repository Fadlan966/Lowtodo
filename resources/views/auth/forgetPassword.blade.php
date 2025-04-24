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
    <style>
        body {
            font-family: 'League Spartan', sans-serif;
        }

        .animate-appear {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="flex justify-center items-center min-h-screen bg-theme-bg p-4">
    <div class="bg-theme-card p-8 shadow-xl rounded-xl w-full max-w-md text-white border border-gray-800 animate-appear">
        <!-- Header with logo -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-500">
                Reset Password
            </h2>
            <div class="bg-theme-input p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
        </div>

        <p class="text-gray-300 mb-6">Enter your email address to receive a password reset link</p>

        @if (Session::has('message'))
            <div
                class="bg-green-500/20 border border-green-500 text-green-100 text-sm p-3 mb-6 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-300" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                {{ Session::get('message') }}
            </div>
        @endif

        <form action="{{ route('forget.password.post') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email_address" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>
                    <input type="email" id="email_address" name="email" placeholder="name@example.com" required
                        autofocus
                        class="w-full pl-10 p-3 border border-gray-700 rounded-lg bg-theme-input text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('email') border-red-500 @enderror">
                </div>
                @if ($errors->has('email'))
                    <span class="text-red-400 text-sm mt-1 block">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <!-- Button Reset -->
            <button type="submit"
                class="w-full bg-theme-accent text-white py-3 rounded-lg hover:bg-blue-500 transition duration-200 font-medium flex justify-center items-center">
                <span>Send Reset Link</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </form>

        <!-- Login Link -->
        <div class="mt-8 text-center">
            <p class="text-gray-300">Remember your password?
                <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium transition">Sign
                    in</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="mt-8 pt-4 border-t border-gray-800 text-center text-gray-500 text-xs">
            <p>© 2025 lowTodo. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
