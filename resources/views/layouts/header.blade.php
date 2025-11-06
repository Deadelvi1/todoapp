<!-- Navigation Header -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('home') }}">
            Study Timer
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if(session()->has('user'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('study-goals.*') ? 'active' : '' }}" href="{{ route('study-goals.index') }}">Study Goals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('study-sessions.*') ? 'active' : '' }}" href="{{ route('study-sessions.index') }}">Sessions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('todos.*') ? 'active' : '' }}" href="{{ route('todos.index') }}">Tasks</a>
                    </li>
                @endif
            </ul>

            <!-- Authentication Links -->
            <ul class="navbar-nav">
                @if(session()->has('user'))
                    <li class="nav-item dropdown">
                        @php $u = session('user'); @endphp
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{ is_array($u) ? ($u['name'] ?? 'User') : ($u->name ?? 'User') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Sign Out</a></li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
