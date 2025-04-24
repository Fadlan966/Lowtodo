<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lowTodo | Welcome</title>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="flex justify-center items-center min-h-screen bg-gradient-to-br from-theme-bg to-gray-900 p-4">
    <div class="bg-theme-card p-8 shadow-2xl rounded-2xl w-full max-w-md text-white border border-gray-800 backdrop-blur-sm relative overflow-hidden">
        <!-- Background subtle pattern -->
        <div class="absolute inset-0 bg-grid-pattern opacity-5 pointer-events-none"></div>

        <!-- Accent glow -->
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-theme-accent/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Header with logo -->
        <div class="flex justify-between items-center mb-10 relative">
            <h2 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-500">
                Welcome
            </h2>
            <div class="bg-theme-input p-3 rounded-lg shadow-lg border border-gray-700/50">
                <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/ab3a8b29f00131f346e3e282b409215d63484f09"
                    alt="Logo" class="h-8">
            </div>
        </div>

        <!-- Tagline -->
        <p class="text-gray-400 mb-8 text-center">Streamline your tasks. Elevate your productivity.</p>

        <!-- Buttons for Login/Register -->
        <div class="space-y-4 mb-10 relative">
            <a href="{{ route('login') }}" class="w-full bg-gradient-to-r from-theme-accent to-blue-600 text-white py-3 px-4 rounded-lg hover:from-blue-600 hover:to-theme-accent transition-all duration-300 font-medium flex justify-center items-center shadow-lg shadow-blue-500/20">
                <span>Sign In</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>

            <a href="{{ route('register') }}" class="w-full bg-theme-input border border-theme-accent text-theme-accent py-3 px-4 rounded-lg hover:bg-theme-accent hover:text-white transition-all duration-300 font-medium flex justify-center items-center shadow-lg">
                <span>Create Account</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                </svg>
            </a>
        </div>

        <!-- Feature highlights -->
        <div class="bg-gradient-to-br from-theme-input to-theme-input/70 rounded-xl p-5 mb-8 shadow-lg border border-gray-700/50 relative">
            <h3 class="text-blue-400 font-medium mb-4 flex items-center">
                <i class="fas fa-star text-xs mr-2"></i>
                Why Choose lowTodo
            </h3>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-blue-400 mt-1"></i>
                    <span class="text-gray-300">Dark Mode Optimized</span>
                </div>
                <div class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-blue-400 mt-1"></i>
                    <span class="text-gray-300">Clean Interface</span>
                </div>
                <div class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-blue-400 mt-1"></i>
                    <span class="text-gray-300">Cloud Syncing</span>
                </div>
                <div class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-blue-400 mt-1"></i>
                    <span class="text-gray-300">Priority Sorting</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="pt-4 border-t border-gray-700/50 text-center text-gray-500 text-xs flex items-center justify-between">
            <p>© 2025 lowTodo</p>
            <div class="flex space-x-3">
                <a href="#" class="hover:text-gray-300 transition-colors">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="hover:text-gray-300 transition-colors">
                    <i class="fab fa-github"></i>
                </a>
                <a href="#" class="hover:text-gray-300 transition-colors">
                    <i class="fas fa-envelope"></i>
                </a>
            </div>
        </div>
    </div>

    <style>
        .bg-grid-pattern {
            background-image:
                linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</body>

</html>
