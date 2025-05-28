<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>

    <style>
        .sidebar-scrollable {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sidebar-scrollable::-webkit-scrollbar {
            width: 0;
            height: 0;
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

        #sidebar {
            width: 250px;
            transition: width 0.3s ease;
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

        /* Sidebar nav */
        #sidebar .nav-link {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            padding: .75rem 1rem;
            transition: all 0.2s ease;
        }

        #sidebar .nav-link i {
            width: 1.25rem;
            text-align: center;
            margin-right: .75rem;
            flex-shrink: 0;
        }

        #sidebar .nav-link.active,
        #sidebar .nav-link:hover {
            background: #b71c1c;
            color: #fff;
        }

        #sidebar .nav-link.active i {
            color: #fff;
        }
    </style>
</head>

@php
    $user = Auth::user();
@endphp

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
                style="width: 100vw; height: 100vh; background: white; overflow: hidden; justify-content: flex-start; align-items: stretch; display: flex;">
                <nav id="sidebar">
                    <div class="sidebar-scrollable bg-danger" style="height: 100vh; overflow-y: auto;">
                        <button class="bg-black" id="sidebarToggle" style="height:3rem; width:100%"><i
                                class="fas fa-bars"></i></button>
                        <ul class="nav flex-column sidebar-group">
                            @foreach ($sidebarMenu as $item)
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
                        @if (Auth::check() && in_array($user->role, ['doctor', 'admin']))
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
                        @if (Auth::check() && $user->role === 'admin')
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
                    </div>
                </nav>
                <div style="flex: 1;">
                    <nav class="bg-white" style="height:3rem">
                        <button id="sidebarToggle" style="height:3rem; width:3rem"><i class="fas fa-bars"></i></button>
                    </nav>
                    <div style="height:100%; background-color: #F5F5F5;"></div>
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
        });
    </script>
</body>

</html>
