<!-- Navbar with Gaussian Blur -->
<nav class="backdrop-blur-md bg-white/60 border-b border-white/30 fixed top-0 left-0 w-full z-50">
    <div class="max-w-[1440px] mx-auto flex justify-between items-center px-4 py-3">
        <!-- Logo -->
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-gradient-to-tr from-indigo-800 to-sky-400 rounded-lg"></div>
            <div class="flex flex-col leading-tight">
                <span class="font-semibold text-lg">Study Timer</span>
                <span class="text-[11px] text-gray-500 hidden sm:block">Tasks • Goals • Deep Work</span>
            </div>
        </div>

        <!-- Desktop Nav Links -->
        <div class="hidden md:flex items-center gap-6 text-gray-700">
            @if(session()->has('user'))
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-1 transition-all duration-300 hover:scale-90 {{ request()->routeIs('dashboard') ? 'text-black underline underline-offset-8 font-semibold' : 'hover:text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="currentColor"
                              d="M19.5 10a.5.5 0 0 0-1 0zm-14 0a.5.5 0 0 0-1 0zm15.146 2.354a.5.5 0 0 0 .708-.708zM12 3l.354-.354a.5.5 0 0 0-.708 0zm-9.354 8.646a.5.5 0 0 0 .708.708zM7 21.5h10v-1H7zM19.5 19v-9h-1v9zm-14 0v-9h-1v9zm15.854-7.354l-9-9l-.708.708l9 9zm-9.708-9l-9 9l.708.708l9-9zM17 21.5a2.5 2.5 0 0 0 2.5-2.5h-1a1.5 1.5 0 0 1-1.5 1.5zm-10-1A1.5 1.5 0 0 1 5.5 19h-1A2.5 2.5 0 0 0 7 21.5z"/>
                    </svg>
                    Dashboard
                </a>

                <!-- Tasks -->
                <a href="{{ route('study_tasks.index') }}"
                   class="flex items-center gap-1 transition-all duration-300 hover:scale-90 {{ request()->routeIs('study_tasks.*') ? 'text-black underline underline-offset-8 font-semibold' : 'hover:text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="square" stroke-width="1">
                            <path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2a10 10 0 0 1 3.847.767"/>
                            <path d="m22 4.5l-10 10L7.5 10"/>
                        </g>
                    </svg>
                    Tasks
                </a>

                <!-- Goals -->
                <a href="{{ route('study-goals.index') }}"
                   class="flex items-center gap-1 transition-all duration-300 hover:scale-90 {{ request()->routeIs('study-goals.*') ? 'text-black underline underline-offset-8 font-semibold' : 'hover:text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1">
                            <path d="M10.66 10.66A1.9 1.9 0 0 0 10.1 12a1.9 1.9 0 0 0 1.9 1.9a1.9 1.9 0 0 0 1.34-.56"/>
                            <path d="M12 6.3a5.7 5.7 0 1 0 5.7 5.7"/>
                            <path d="M12 2.5a9.5 9.5 0 1 0 9.5 9.5m-5.975-3.524L12.95 11.05"/>
                            <path d="M20.94 5.844L17.7 6.3l.456-3.24a.19.19 0 0 0-.313-.161l-2.148 2.137a1.9 1.9 0 0 0-.513 1.72l.342 1.72l1.72.341a1.9 1.9 0 0 0 1.72-.513L21.1 6.157a.19.19 0 0 0-.162-.313"/>
                        </g>
                    </svg>
                    Goals
                </a>

                <!-- Timer -->
                @php $firstGoal = \App\Models\StudyGoal::first(); @endphp
                <a href="{{ $firstGoal ? route('study_sessions.index', ['goalId' => $firstGoal->id]) : '#' }}"
                   class="flex items-center gap-1 transition-all duration-300 hover:scale-90 {{ request()->routeIs('study_sessions.*') ? 'text-black underline underline-offset-8 font-semibold' : 'hover:text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                              d="m19 7l-1.343 1.343m0 0A8 8 0 1 0 6.343 19.657A8 8 0 0 0 17.657 8.343M12 10v4M9 3h6"/>
                    </svg>
                    Timer
                </a>

                <!-- User Info -->
                @php $u = session('user'); @endphp
                <div class="flex items-center gap-2 ml-4">
                    <span class="text-gray-600 text-sm border border-black rounded-full py-1 px-2 flex gap-1 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-width="1">
                                <path stroke-linejoin="round" d="M4 18a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z"/>
                                <circle cx="12" cy="7" r="3"/>
                            </g>
                        </svg>
                        {{ is_array($u) ? ($u['name'] ?? 'User') : ($u->name ?? 'User') }}
                    </span>
                    <a href="{{ route('logout') }}"
                       class="bg-black text-white text-sm px-3 py-1.5 rounded-lg hover:bg-gray-800 hover:scale-90 transition-all duration-300">
                       Log out
                    </a>
                </div>
            @else
                <!-- Guest Links -->
                <a href="{{ route('login') }}"
                   class="{{ request()->routeIs('login') ? 'text-black font-semibold' : 'hover:text-black' }}">
                   Sign In
                </a>
                <a href="{{ route('register') }}"
                   class="{{ request()->routeIs('register') ? 'text-black font-semibold' : 'hover:text-black' }}">
                   Register
                </a>
            @endif
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobileMenuBtn" class="md:hidden p-2 hover:bg-gray-100/50 rounded-lg">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden backdrop-blur-md bg-white/60 border-t border-white/30">
        <div class="px-4 py-3 space-y-3">
            @if(session()->has('user'))
                <a href="{{ route('dashboard') }}" class="block text-gray-700 hover:text-black">Dashboard</a>
                <a href="{{ route('study_tasks.index') }}" class="block text-gray-700 hover:text-black">Tasks</a>
                <a href="{{ route('study-goals.index') }}" class="block text-gray-700 hover:text-black">Goals</a>
                <a href="{{ $firstGoal ? route('study_sessions.index', ['goalId' => $firstGoal->id]) : '#' }}" class="block text-gray-700 hover:text-black">History</a>

                <div class="pt-3 border-t border-gray-200/50">
                    @php $u = session('user'); @endphp
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 text-sm border border-black rounded-full py-1 px-2 flex gap-1 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                 viewBox="0 0 24 24"><g fill="none" stroke="currentColor"
                                 stroke-width="1"><path stroke-linejoin="round"
                                 d="M4 18a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z"/><circle
                                 cx="12" cy="7" r="3"/></g></svg>
                            {{ is_array($u) ? ($u['name'] ?? 'User') : ($u->name ?? 'User') }}
                        </span>
                        <a href="{{ route('logout') }}" class="bg-black text-white text-sm px-3 py-1.5 rounded-lg hover:bg-gray-800">
                            Log out
                        </a>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                   class="block py-2 text-gray-700 hover:text-black {{ request()->routeIs('login') ? 'font-semibold' : '' }}">
                   Sign In
                </a>
                <a href="{{ route('register') }}"
                   class="block py-2 text-gray-700 hover:text-black {{ request()->routeIs('register') ? 'font-semibold' : '' }}">
                   Register
                </a>
            @endif
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobileMenuBtn').addEventListener('click', function() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    });
</script>
