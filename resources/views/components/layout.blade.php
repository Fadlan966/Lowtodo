<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="{{ asset('js/sidebar.js') }}"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #111827; /* Changed from #06294d to dark gray */
        }

        .sidebar {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-text {
            font-weight: 600;
            letter-spacing: 0.4px;
        }

        .navlink a li {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
            border-radius: 14px;
            padding: 0.875rem 1.25rem;
        }

        .navlink a li:hover {
            background-color: #4f46e5;
            transform: translateX(5px);
            box-shadow: 0 8px 16px rgba(79, 70, 229, 0.3);
        }

        .active-nav-item {
            background-color: #4f46e5;
            box-shadow: 0 8px 16px rgba(79, 70, 229, 0.3);
        }

        .logo-container {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.25);
            padding: 1rem;
            margin-bottom: 2.5rem;
            transform: translateY(-5px);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(-5px); }
            50% { transform: translateY(0px); }
            100% { transform: translateY(-5px); }
        }

        .logo-text {
            background: linear-gradient(135deg, #ffffff, #e2e8f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .profile-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02));
            border-radius: 16px;
            padding: 1.25rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .profile-container:hover {
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .dropdown-menu {
            background-color: #1e293b;
            border-radius: 14px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .dropdown-item {
            transition: all 0.3s ease;
            border-radius: 10px;
            margin: 0.25rem;
        }

        .dropdown-item:hover {
            background-color: #4f46e5;
            transform: translateX(5px);
        }

        .content-area {
            background-color: #1e293b; /* Changed from #42044b to dark blue-gray */
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin: 2rem;
            padding: 2.5rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            border-radius: 14px;
            padding: 0.875rem 1.75rem;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 16px rgba(79, 70, 229, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(79, 70, 229, 0.4);
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .nav-icon {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .navlink a li:hover .nav-icon {
            transform: scale(1.1);
        }

        header {
            background: rgba(30, 41, 59, 0.8); /* Changed to dark color */
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .profile-avatar {
            border: 3px solid #4f46e5;
            transition: transform 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1f2937; /* Changed to darker color */
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #4b5563; /* Changed to gray */
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6366f1; /* Changed to indigo */
        }
    </style>
</head>

<body class="overflow-x-hidden">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar p-6 pt-8 relative transition-all duration-300 w-72 flex flex-col justify-between">
            <div>
                <!-- Logo -->
                <div class="logo-container flex items-center justify-center mb-8 py-3">
                    <img src="{{ asset('images/lowTodo_Icon-preview.png') }}" alt="Logo" class="w-12 h-12 mr-3">
                    <h1 class="logo-text text-3xl">Lowtodo</h1>
                </div>

                <!-- Profile -->
                <div class="profile-container flex items-center gap-4">
                    <div class="relative w-14 h-14 overflow-hidden bg-gradient-to-br from-indigo-200 to-indigo-400 rounded-full shadow-lg profile-avatar">
                        @if (auth()->user()->avatar)
                            <img src="{{ asset('avatars/' . auth()->user()->avatar) }}" alt="Profile Image"
                                class="w-full h-full object-cover">
                        @else
                            <svg class="absolute w-16 h-16 text-indigo-500 -left-1" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-semibold text-md truncate max-w-[140px]">
                            {{ Auth::user()->name }}
                        </span>
                        <span class="text-indigo-200 text-xs">
                            @if (Auth::user()->email)
                                {{ Str::limit(Auth::user()->email, 18) }}
                            @else
                                Member
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="mt-10">
                    <h2 class="text-indigo-300 text-xs font-medium uppercase tracking-wider mb-5 px-4">Main Menu</h2>
                    <ul class="navlink">
                        <a href="{{ route('dashboard') }}">
                            <li
                                class="flex items-center px-4 py-3 cursor-pointer rounded-lg transition {{ request()->routeIs('dashboard') ? 'active-nav-item' : '' }}">
                                <i class="fas fa-columns nav-icon text-white w-6"></i>
                                <span class="sidebar-text text-white ml-3">Dashboard</span>
                            </li>
                        </a>

                        <li class="flex items-center px-4 py-3 cursor-pointer rounded-lg transition hover:bg-indigo-600"
                            id="openModalCreate">
                            <a href="#" class="flex items-center w-full">
                                <i class="fas fa-plus-circle nav-icon text-white w-6"></i>
                                <span class="sidebar-text text-white ml-3">Create Project</span>
                            </a>
                        </li>

                        <li class="relative mb-2">
                            <button id="settingToggle"
                                class="flex items-center w-full px-4 py-3 hover:bg-indigo-600 rounded-lg transition text-white">
                                <i class="fas fa-cog nav-icon w-6"></i>
                                <span class="sidebar-text ml-3">Settings</span>
                                <i class="fas fa-chevron-down ml-auto transition-transform duration-300"
                                    id="dropdownArrow"></i>
                            </button>
                            <ul id="settingDropdown" class="dropdown-menu ml-4 mt-2 space-y-1 hidden overflow-hidden py-2">
                                <li class="dropdown-item">
                                    <a href="{{ route('user.profile') }}"
                                        class="block px-4 py-2 text-white text-sm rounded-lg">
                                        <i class="fas fa-user mr-2 text-xs"></i> Profile
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <h2 class="text-indigo-300 text-xs font-medium uppercase tracking-wider mb-5 mt-10 px-4">Account</h2>
                    <ul class="navlink">
                        <li class="flex items-center px-4 py-3 cursor-pointer rounded-lg transition hover:bg-red-500" id="openLogout">
                            <a href="#" class="flex items-center w-full">
                                <i class="fas fa-sign-out-alt nav-icon text-white w-6"></i>
                                <span class="sidebar-text text-white ml-3">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-auto pt-8 px-2">
                <div class="text-xs text-indigo-300 opacity-70 text-center">
                    <p>Lowtodo v1.2.5</p>
                    <p class="mt-1">© 2025 All Rights Reserved</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="flex-1 flex flex-col">
            <header class="px-8 py-5 shadow-sm">
                <div class="flex justify-between items-center">
                    @if(request()->routeIs('dashboard'))
                    <h1 class="text-2xl font-bold text-gray-100">Dashboard</h1> <!-- Changed text color to light -->
                    @else
                    <h1 class="text-2xl font-bold text-gray-100">@yield('header-title')</h1> <!-- Changed text color to light -->
                    @endif
                    <div class="flex items-center gap-4">
                        <div>
                            <span class="text-sm font-medium text-gray-300"> <!-- Changed text color to light -->
                                {{ now()->format('l, F j, Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content-area flex-1">
                @yield('contents')
            </div>
        </div>
    </div>

    @include('components.modalCreateProject')
    @include('components.modalLogout')

    <script>
        function toggleModal(modalId, show) {
            const modal = document.getElementById(modalId);
            if (modal) {
                if (show) {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    setTimeout(() => {
                        const modalContent = modal.querySelector('.modal-content');
                        if (modalContent) modalContent.classList.add('scale-100', 'opacity-100');
                    }, 10);
                } else {
                    const modalContent = modal.querySelector('.modal-content');
                    if (modalContent) {
                        modalContent.classList.remove('scale-100', 'opacity-100');
                        setTimeout(() => {
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                        }, 300);
                    } else {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                }
            }
        }

        document.getElementById('openModalCreate')?.addEventListener('click', () => toggleModal('modalCreateTodo', true));
        document.getElementById('openLogout')?.addEventListener('click', () => toggleModal('modalLogout', true));
        document.getElementById('closeModalCreateTodo')?.addEventListener('click', () => toggleModal('modalCreateTodo', false));
        document.getElementById('closeModalLogout')?.addEventListener('click', () => toggleModal('modalLogout', false));

        window.addEventListener('click', (event) => {
            ['modalCreateTodo', 'modalLogout'].forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal && event.target === modal) toggleModal(modalId, false);
            });
        });

        const settingToggle = document.getElementById('settingToggle');
        const settingDropdown = document.getElementById('settingDropdown');
        const dropdownArrow = document.getElementById('dropdownArrow');
        let isDropdownOpen = false;

        settingToggle?.addEventListener('click', () => {
            isDropdownOpen = !isDropdownOpen;
            if (isDropdownOpen) {
                settingDropdown.classList.remove('hidden');
                setTimeout(() => {
                    settingDropdown.style.maxHeight = settingDropdown.scrollHeight + 'px';
                    dropdownArrow.classList.add('rotate-180');
                }, 10);
            } else {
                settingDropdown.style.maxHeight = '0px';
                dropdownArrow.classList.remove('rotate-180');
                setTimeout(() => {
                    settingDropdown.classList.add('hidden');
                }, 300);
            }
        });

        // Keyboard shortcut
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && event.key === 'n') {
                event.preventDefault();
                toggleModal('modalCreateTodo', true);
            }
        });

        // Add subtle hover effect to content area
        const contentArea = document.querySelector('.content-area');
        contentArea.addEventListener('mouseenter', () => {
            contentArea.style.transform = 'scale(1.005)';
        });
        contentArea.addEventListener('mouseleave', () => {
            contentArea.style.transform = 'scale(1)';
        });
    </script>
</body>

</html>
