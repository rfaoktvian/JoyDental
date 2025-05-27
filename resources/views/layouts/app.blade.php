<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .main-content-adjusted {
            position: relative;
            top: 56px;
            height: calc(100vh - 56px);
            overflow-y: auto;
        }

        /* ----- Sidebar base ----- */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 240px;
            background: #d32f2f;
            color: #fff;
            overflow: hidden;
            transition: width 0.2s ease-in-out;
            z-index: 900;

            top: 56px;
            height: calc(100vh - 56px);
        }

        /* ----- Collapsed state ----- */
        body.sidebar-collapsed #sidebar {
            width: 56px;
        }

        /* hide text when collapsed */
        body.sidebar-collapsed #sidebar .sidebar-text {
            opacity: 0;
            transform: translateX(-10px);
        }

        .sidebar-group {
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* ----- Sidebar header (toggle) ----- */
        .sidebar-header {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            flex-shrink: 0;
        }

        #sidebarToggle {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0;
        }

        /* ----- Sidebar nav ----- */
        #sidebar .nav-link {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            padding: .75rem 1rem;
            transition: background .2s, color .2s;
        }

        #sidebar .nav-link i {
            width: 1.25rem;
            text-align: center;
            margin-right: .75rem;
            flex-shrink: 0;
        }

        #sidebar .nav-link .sidebar-text {
            white-space: nowrap;
            transition: opacity .2s, transform .2s;
        }

        #sidebar .nav-link.active,
        #sidebar .nav-link:hover {
            background: #b71c1c;
            color: #fff;
        }

        #sidebar .nav-link.active i {
            color: #fff;
        }

        /* ----- Content wrapper ----- */
        #content-wrapper {
            margin-left: 240px;
            transition: margin-left 0.2s ease-in-out;
        }

        .wrapper-content {
            top: 56px;
            height: calc(100vh - 56px);
        }

        .toggle-btn {
            background: none;
            border: none;
            color: inherit;
            width: 100%;
            display: flex;
            align-items: center;
            padding: .75rem 1rem;
            cursor: pointer;
        }

        .toggle-btn i {
            width: 1.25rem;
            text-align: center;
            margin-right: .75rem;
        }

        body.sidebar-collapsed #content-wrapper {
            margin-left: 56px;
        }

        body.sidebar-collapsed .toggle-btn .sidebar-text {
            opacity: 0;
            transform: translateX(-10px);
        }

        nav.navbar {
            position: fixed;
            width: 100vw;
            top: 0;
            z-index: 1000;
            /* sit above sidebar/content */
        }
    </style>
</head>

<body>
    <div id="app" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        {{-- NAVBAR & SIDEBAR --}}
        @if (!in_array(Route::currentRouteName(), $hideNavRoutes))
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-2">
                <a class="navbar-brand text-danger ms-3" href="#">
                    <i class="bi bi-heart-pulse-fill me-1"></i> AppointDoc
                </a>
                <span class="ms-2 text-muted fst-italic">by RS Siaga Sedia</span>

                <div class="ms-auto d-flex align-items-center gap-3">
                    <div class="input-group" style="width:300px">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input class="form-control" placeholder="Cari dokter, poliklinik...">
                    </div>
                    @guest
                        @includeWhen(Route::has('login'), 'partials.login-modal')
                        @if (Route::has('login'))
                            <a class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a>
                        @endif
                        @if (Route::has('register'))
                            <a class="btn btn-danger text-white" href="{{ route('register') }}">Daftar</a>
                        @endif
                    @else
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                                href="#">{{ Auth::user()->name }}</a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit()">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </nav>

            <nav id="sidebar">
                <div class="sidebar-header">
                    <button id="sidebarToggle"><i class="fas fa-bars"></i></button>
                </div>
                <ul class="nav flex-column sidebar-group">
                    @foreach ($sidebarMenu as $item)
                        <li class="nav-item">
                            <a href="{{ route($item['route']) }}"
                                class="nav-link {{ Request::routeIs($item['route']) ? 'active' : '' }}">
                                <i class="{{ $item['icon'] }}"></i>
                                <span class="sidebar-text">{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                @if (Auth::check() && in_array(Auth::user()->role, ['doctor', 'admin']))
                    <ul class="nav flex-column sidebar-group">
                        @foreach ($siderbarAdminMenu as $item)
                            <li class="nav-item">
                                <a href="{{ route($item['route']) }}"
                                    class="nav-link {{ Request::routeIs($item['route']) ? 'active' : '' }}">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span class="sidebar-text">{{ $item['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                @if (Auth::check() && Auth::user()->role === 'admin')
                    <ul class="nav flex-column sidebar-group">
                        @foreach ($sidebarDokterMenu as $item)
                            <li class="nav-item">
                                <a href="{{ route($item['route']) }}"
                                    class="nav-link {{ Request::routeIs($item['route']) ? 'active' : '' }}">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span class="sidebar-text">{{ $item['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </nav>

            <div id="content-wrapper" style="background-color: #F5F5F5;">
                <div class="container-fluid main-content-adjusted" style="background-color: #F5F5F5;">
                    <div class="container-fluid col-12 col-lg-15 px-4 py-3">
                        <main>
                            @yield('content')
                        </main>
                    </div>
                </div>
            </div>
        @else
            <main>

                @yield('content')
            </main>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            const toggle = document.querySelectorAll('#sidebarToggle');
            if (localStorage.getItem('sidebar-collapsed') === 'true') {
                body.classList.add('sidebar-collapsed');
            }
            toggle.forEach(btn =>
                btn.addEventListener('click', () => {
                    const isCollapsed = body.classList.toggle('sidebar-collapsed');
                    localStorage.setItem('sidebar-collapsed', isCollapsed);
                })
            );
        });
    </script>
</body>

</html>
