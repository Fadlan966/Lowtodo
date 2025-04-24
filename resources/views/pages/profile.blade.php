@extends('components.layout')

@section('contents')
    <div class="max-w-6xl mx-auto py-16 px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {{-- Edit Profile --}}
            <div class="bg-gray-900 rounded-3xl shadow-xl p-8 border border-gray-800 hover:shadow-2xl hover:shadow-indigo-500/20 transition-shadow duration-300">
                <h2 class="text-2xl font-bold text-indigo-400 mb-8 text-center flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Edit Profile
                </h2>

                @if (session('success'))
                    <div class="mb-6 px-5 py-4 rounded-xl bg-green-900 text-green-200 border-l-4 border-green-500 shadow-md alert-success">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Avatar Upload --}}
                    <div class="flex flex-col sm:flex-row items-center gap-6 mb-2">
                        <div class="flex-shrink-0">
                            <img src="/avatars/{{ auth()->user()->avatar }}" alt="Avatar"
                                class="w-24 h-24 rounded-full object-cover border-4 border-indigo-900 shadow-lg ring-2 ring-indigo-500">
                        </div>
                        <div class="flex-grow w-full">
                            <label for="avatar" class="block text-sm font-medium text-gray-300 mb-1">Update Avatar</label>
                            <div class="relative">
                                <input type="file" name="avatar" id="avatar"
                                    class="w-full text-sm text-gray-300 file:mr-4 file:py-3 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-700 file:text-gray-100 hover:file:bg-indigo-600 border border-gray-700 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-gray-800 @error('avatar') border-red-500 @enderror">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-xs">PNG, JPG</div>
                            </div>
                            @error('avatar')
                                <span class="text-sm text-red-400 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="name" id="name" value="{{ auth()->user()->name }}"
                                class="pl-10 w-full border border-gray-700 rounded-lg p-3 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition bg-gray-800 text-white @error('name') border-red-500 @enderror">
                        </div>
                        @error('name')
                            <span class="text-sm text-red-400 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="text" name="email" id="email" value="{{ auth()->user()->email }}"
                                class="pl-10 w-full border border-gray-700 rounded-lg p-3 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition bg-gray-800 text-white @error('email') border-red-500 @enderror">
                        </div>
                        @error('email')
                            <span class="text-sm text-red-400 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-1">New Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password"
                                class="pl-10 w-full border border-gray-700 rounded-lg p-3 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition bg-gray-800 text-white @error('password') border-red-500 @enderror"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password', this)"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-indigo-400 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10a9.95 9.95 0 011.17-4.747M9.88 9.88a3 3 0 104.24 4.24M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-sm text-red-400 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-300 mb-1">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <input type="password" name="confirm_password" id="confirm_password"
                                class="pl-10 w-full border border-gray-700 rounded-lg p-3 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition bg-gray-800 text-white @error('confirm_password') border-red-500 @enderror"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword('confirm_password', this)"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-indigo-400 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10a9.95 9.95 0 011.17-4.747M9.88 9.88a3 3 0 104.24 4.24M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        @error('confirm_password')
                            <span class="text-sm text-red-400 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="pt-6">
                        <button type="submit"
                            class="w-full bg-indigo-700 hover:bg-indigo-600 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg hover:shadow-indigo-600/30 transition duration-200 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>

            {{-- Recent Activity --}}
            <div class="bg-gray-900 rounded-3xl shadow-xl p-8 border border-gray-800 hover:shadow-2xl hover:shadow-indigo-500/20 transition-shadow duration-300 mt-10 lg:mt-0">
                <h3 class="text-2xl font-bold text-indigo-400 mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Recent Activity
                </h3>

                @if (session('success_activity'))
                    <div
                        class="mb-6 px-5 py-4 rounded-xl bg-green-900 text-green-200 border-l-4 border-green-500 shadow-md alert-success">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ session('success_activity') }}
                        </div>
                    </div>
                @endif

                <div class="space-y-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                    @forelse ($activities as $activity)
                        <div class="bg-gray-800 hover:bg-gray-700 border border-gray-700 p-4 rounded-xl flex justify-between items-start transition-colors duration-200">
                            <div class="text-gray-300">
                                <div class="font-semibold text-indigo-400 mb-1">{{ $activity->title }}</div>
                                <div class="flex items-center text-xs text-gray-400 mb-1">
                                    <span class="inline-flex items-center justify-center bg-indigo-900 text-indigo-300 px-2 py-0.5 rounded-full mr-2">
                                        {{ $activity->type ?? 'activity' }}
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $activity->created_at->diffForHumans() }}
                                </div>
                                @if ($activity->description)
                                    <div class="text-xs text-gray-400">{{ $activity->description }}</div>
                                @endif
                            </div>
                            <form action="{{ route('activity.delete', $activity->id) }}" method="POST" class="ml-4 flex-shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-400 text-xs font-medium hover:text-red-300 hover:underline focus:outline-none focus:ring-2 focus:ring-red-500 rounded-full px-2 py-1 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="text-gray-400">No recent activity found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function togglePassword(fieldId, button) {
                const input = document.getElementById(fieldId);
                const icon = button.querySelector('svg');

                if (input.type === "password") {
                    input.type = "text";
                    icon.innerHTML =
                        `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/>`;
                } else {
                    input.type = "password";
                    icon.innerHTML =
                        `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10a9.95 9.95 0 011.17-4.747M9.88 9.88a3 3 0 104.24 4.24M3 3l18 18"/>`;
                }
            }

            // Auto hide alert after 3 seconds
            document.addEventListener('DOMContentLoaded', () => {
                const alerts = document.querySelectorAll('.alert-success');
                alerts.forEach(alert => {
                    setTimeout(() => {
                        alert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                        setTimeout(() => alert.remove(), 500);
                    }, 3000);
                });
            });
        </script>

        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #1f2937;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #4b5563;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #6366f1;
            }
        </style>
    @endpush
@endsection
