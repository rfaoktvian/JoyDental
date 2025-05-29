<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AppointDoc</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        document.addEventListener('htmx:configRequest', (e) => {

            console.log('HTMX request config:', e.detail);
            e.detail.headers['X-CSRF-TOKEN'] =
                document.querySelector('meta[name="csrf-token"]').content;
        });
    </script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>

    <style>
        #page-content.custom-scrollbar {
            height: 100vh;
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        #page-content.custom-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .sidebar-scrollable {
            height: 100vh;
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sidebar-scrollable::-webkit-scrollbar {
            display: none;
        }

        #sidebarToggle {
            background: none;
            border: none;
            color: #000000;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0;
        }

        .sidebar-header {
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.25);
        }

        .sidebar-group-title {
            font-size: 0.6875rem;
            color: rgba(255, 255, 255, 0.75);
            padding: 0.5rem 1rem 0.25rem;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
            transition: all 0.3s ease;
        }

        .sidebar-group {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .sidebar-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.25);
            margin: 0.5rem 1rem;
            transition: opacity 0.3s ease;
        }

        #sidebar {
            width: 250px;
            transition: width 0.3s ease;
            background: #c62828;
        }

        #sidebar .nav-link {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            padding: .85rem 0.85rem;
            transition: all 0.2s ease;

        }

        #sidebar .nav-link i {
            width: 1.25rem;
            text-align: center;
            margin-right: .75rem;
            flex-shrink: 0;
        }

        .nav-link:hover {
            background: #b71c1c;
            color: #fff;
        }

        .nav-link.active {
            background: #b71c1c;
            color: #fff;
            font-weight: 500;
        }

        #sidebar .nav-link.active i {
            color: #fff;
        }

        #sidebar .sidebar-text {
            transition: opacity 0.3s ease;
            display: inline-block;
            white-space: nowrap;
        }

        body.sidebar-collapsed #sidebar {
            width: 3rem;
        }

        body.sidebar-collapsed #sidebar .sidebar-text {
            opacity: 0;
        }

        .sidebar-text {
            opacity: 1;
            max-height: 100px;
            overflow: hidden;
            transition: opacity 0.3s ease, max-height 0.3s ease;
        }

        body.sidebar-collapsed .sidebar-text,
        body.sidebar-collapsed .sidebar-group-title {
            opacity: 0;
            max-height: 0;
            margin: 0;
            padding: 0;
            pointer-events: none;
        }

        body.sidebar-collapsed .sidebar-divider {
            opacity: 1;
        }

        #sidebar,
        #sidebar * {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>

@php
    $user = Auth::user();
@endphp

@if (request()->header('HX-Request'))
    <main id="page-content">
        <div class="custom-container" style="height:100%;">
            <main>
                @yield('content')
            </main>
        </div>
    </main>
@else

    <body hx-boost="true" hx-target="#page-content" hx-push-url="true">
        @includeWhen(Route::has('login'), 'partials.login-modal')

        <div id="app" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
            <div id="htmx-indicator" class="progress"
                style="position:fixed;top:0;left:0;width:0;height:3px;background:#d32f2f;z-index:2000;
                    transition:width .2s">
            </div>
            <script>
                htmx.on("htmx:configRequest", () =>
                    document.getElementById("htmx-indicator").style.width = "100%");
                htmx.on("htmx:afterSwap", () =>
                    document.getElementById("htmx-indicator").style.width = "0%");
            </script>

            <div style="display: flex; height: 100%; width: 100%; overflow: hidden; margin: 0;">
                <div
                    style="width: 100vw; height: 100vh; background-color: #F5F5F5; overflow: hidden; justify-content: flex-start; align-items: stretch; display: flex;">
                    <nav id="sidebar">
                        <div class="sidebar-scrollable">
                            <div class="sidebar-header">
                                <i class="fas fa-heart-pulse text-white fs-5"></i>
                            </div>
                            <div class="sidebar-section">
                                <div class="sidebar-group-title">CLINIC</div>
                                <ul class="nav flex-column sidebar-group">
                                    @foreach ($sidebarMenu as $item)
                                        {{-- skip if not authorized --}}
                                        @if (isset($item['auth']) && $item['auth'] && !Auth::check())
                                            @continue
                                        @endif
                                        <li class="nav-item">
                                            <a href="{{ route($item['route']) }}"
                                                class="nav-link {{ Request::routeIs($item['route']) ? 'active' : '' }}">
                                                <i class="{{ $item['icon'] }}"></i>
                                                <span class="sidebar-text">{{ $item['label'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="sidebar-divider"></div>
                            </div>

                            @if (Auth::check() && $user->role === 'admin')
                                <div class="sidebar-section">
                                    <div class="sidebar-group-title">DOCTOR</div>
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
                                    <div class="sidebar-divider"></div>
                                </div>
                            @endif
                            @if (Auth::check() && in_array($user->role, ['doctor', 'admin']))
                                <div class="sidebar-section">
                                    <div class="sidebar-group-title">Admin</div>
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
                                    <div class="sidebar-divider"></div>
                                </div>
                            @endif

                        </div>
                    </nav>
                    <div style="flex: 1; display: flex; flex-direction: column; height: 100vh; min-width:0;">
                        <nav id="navbar" style="z-index: 1000">
                            <nav class="bg-white shadow-sm border-bottom border-1 border-muted d-flex ms-auto align-items-center"
                                style="height:3rem;">
                                <div class="d-flex align-items-center justify-content-between w-100 px-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <button id="sidebarToggle"
                                            class="btn d-flex align-items-center justify-content-center"
                                            style="height: 3rem;">
                                            <i class="fas fa-bars" style="font-size: 1rem;"></i>
                                        </button>
                                        <div class="d-flex align-items-center">
                                            <div class="vr" style="height: 1.25rem;"></div>
                                        </div>
                                        <p class="mb-0" id="page-title">AppointDoc</p>
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        @guest
                                            @if (Route::has('login'))
                                                <a class="btn btn-outline-danger d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="modal" data-bs-target="#loginModal"
                                                    style="height: 2rem; min-width: 70px;">
                                                    <span class="w-100 text-center">Masuk</span>
                                                </a>
                                            @endif
                                            @if (Route::has('register'))
                                                <a class="btn btn-danger text-white d-flex align-items-center justify-content-center"
                                                    style="height: 2rem; min-width: 70px;" href="{{ route('register') }}">
                                                    <span class="w-100 text-center">Daftar</span>
                                                </a>
                                            @endif
                                        @else
                                            <div class="dropdown">
                                                <a class="d-flex align-items-center text-decoration-none rounded gap-3"
                                                    href="#" role="button" id="profileDropdown"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                                        @if (Auth::check() && $user->role === 'admin')
                                                            <div class="d-flex align-items-center">
                                                                <div class="vr text-muted" style="height: 1.25rem;"></div>
                                                            </div>
                                                            <div class="text-muted small">{{ ucfirst($user->role) }}</div>
                                                        @endif
                                                    </div>
                                                    <img src="{{ asset('images/doctors_login.png') }}" alt="Profile"
                                                        width="32" height="32" class="rounded-circle"
                                                        style="object-fit: cover;">
                                                </a>

                                                <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm"
                                                    aria-labelledby="profileDropdown">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('profil') }}">Profil
                                                            Saya</a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                            Logout
                                                        </a>
                                                        <form id="logout-form" action="{{ route('logout') }}"
                                                            method="POST" class="d-none">
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endguest
                                    </div>
                                </div>
                            </nav>
                        </nav>
                        <main id="page-content" class="custom-scrollbar"
                            style="flex:1 1 0; overflow-y:auto; min-height:0; z-index: 999;">
                            <div class="custom-container" style="height:100%;">
                                <main>
                                    @yield('content')
                                </main>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const body = document.body;

                const toggles = document.querySelectorAll('#sidebarToggle');
                if (localStorage.getItem('sidebar-collapsed') === 'true') {
                    body.classList.add('sidebar-collapsed');
                }
                toggles.forEach(btn => btn.addEventListener('click', () => {
                    console.log('Sidebar toggle clicked');
                    const state = body.classList.toggle('sidebar-collapsed');
                    localStorage.setItem('sidebar-collapsed', state);
                }));
            });

            htmx.on('htmx:afterSwap', () => {
                const path = window.location.pathname.replace(/\/+$/, '');
                document.querySelectorAll('#sidebar .nav-link').forEach(link => {
                    const href = new URL(link.href).pathname.replace(/\/+$/, '');
                    link.classList.toggle('active', href === path);
                });

                console.log('HTMX after swap: Updated sidebar active state');
            });
        </script>
    </body>
@endif

</html>
