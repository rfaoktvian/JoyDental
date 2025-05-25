<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        @if(!in_array(Route::currentRouteName(), $hideNavRoutes))
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-2" id="beranda">
            <div>
                <a class="navbar-brand d-flex align-items-center text-danger fw-bold fs-4" href="#">
                    <i class="bi bi-heart-pulse-fill me-2"></i> AppointDoc
                </a>
                <span class="ms-5 text-black-50 fs-6 fst-italic subtitle">by RS Siaga Sedia</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari dokter, poliklinik...">
                </div>
            </div>
            <div class="ms-auto d-flex align-items-center gap-3">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                        <div class="ms-auto d-flex align-items-center gap-3">
                            @if (Route::has('login'))
                            @include('partials.login-modal')

                            <a class="btn btn-outline-danger px-4" href="#" data-bs-toggle="modal"
                                data-bs-target="#loginModal">
                                {{ __('Masuk') }}
                            </a>
                            @endif

                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="btn btn-danger text-white px-4"
                                    href="{{ route('register') }}">{{ __('Daftar') }}</a>
                            </li>
                            @endif
                        </div>
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @endif

        <div class="d-flex">
            {{-- Sidebar --}}
            @if(!in_array(Route::currentRouteName(), $hideNavRoutes))
            <div class="sidebar-wrapper">
                @include('partials.sidebar')
            </div>
            @endif

            {{-- Page content --}}
            <div id="content-wrapper" class="flex-grow-1">
                <main>
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    @vite(['resources/js/app.js']) {{-- or your compiled JS --}}
</body>

</html>