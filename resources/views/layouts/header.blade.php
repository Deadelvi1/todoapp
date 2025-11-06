<style>
    .navbar-custom {
        background-color: #ffffff !important;
        border-bottom: 1px solid #e5e7eb;
        padding: 0.75rem 0;
    }
    
    .navbar-brand-custom {
        font-weight: 700 !important;
        font-size: 1.25rem !important;
        color: #1d3557 !important;
        text-decoration: none !important;
    }
    
    .navbar-brand-custom:hover {
        color: #1d3557 !important;
    }
    
    .nav-link-custom {
        color: #4a5568 !important;
        font-weight: 500 !important;
        padding: 0.5rem 1rem !important;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    
    .nav-link-custom:hover {
        color: #1d3557 !important;
    }
    
    .nav-link-custom.active {
        color: #1d3557 !important;
        font-weight: 600 !important;
    }
    
    .navbar-nav-custom {
        gap: 0.5rem;
    }
</style>

<!-- Navigation Header -->
<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand navbar-brand-custom" href="{{ route('home') }}">
            Study Timer
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 navbar-nav-custom">
                @if(session()->has('user'))
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                           href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('study-goals.*') ? 'active' : '' }}" 
                           href="{{ route('study-goals.index') }}">
                            Study Goals
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('study-sessions.*') ? 'active' : '' }}" 
                           href="{{ route('study-sessions.index') }}">
                            Sessions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('todos.*') ? 'active' : '' }}" 
                           href="{{ route('todos.index') }}">
                            Tasks
                        </a>
                    </li>
                @endif
            </ul>

            <!-- Authentication Links -->
            <ul class="navbar-nav">
                @if(session()->has('user'))
                    <li class="nav-item dropdown">
                        @php $u = session('user'); @endphp
                        <a class="nav-link nav-link-custom dropdown-toggle" 
                           href="#" 
                           id="userDropdown" 
                           role="button" 
                           data-bs-toggle="dropdown" 
                           aria-expanded="false">
                            {{ is_array($u) ? ($u['name'] ?? 'User') : ($u->name ?? 'User') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Sign Out</a></li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('login') ? 'active' : '' }}" 
                           href="{{ route('login') }}">
                            Sign In
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('register') ? 'active' : '' }}" 
                           href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
