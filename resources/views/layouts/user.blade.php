<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Laundry Track</title>
    @vite(['resources/css/app.css', 'resources/css/user.css', 'resources/js/app.js'])
</head>
<body>

    {{-- Mobile hamburger --}}
    <button class="mobile-menu-toggle" onclick="toggleMenu()" aria-label="Toggle menu">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    {{-- Mobile overlay --}}
    <div class="mobile-overlay" onclick="toggleMenu()"></div>

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h1>LAUNDRY TRACK</h1>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('user.dashboard') }}"
                   class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('user.orders.index') }}"
                   class="{{ request()->routeIs('user.orders.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Order History
                </a>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile
                </a>
            </li>
        </ul>
    </aside>

    {{-- Main content --}}
    <main class="main-content">

        {{-- Topbar --}}
        <div class="topbar">
            <h2>@yield('page-title', 'Dashboard')</h2>
            <div class="user-menu">
                <span>{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        {{-- Page content --}}
        @yield('content')

    </main>

    <script>
        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            const toggle  = document.querySelector('.mobile-menu-toggle');

            const isOpen = sidebar.classList.toggle('mobile-visible');
            overlay.classList.toggle('active', isOpen);
            toggle.style.display = isOpen ? 'none' : '';
        }

        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) toggleMenu();
            });
        });
    </script>

</body>
</html>
