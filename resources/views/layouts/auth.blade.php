@extends('layouts.app', [($hideNav = false)])

@section('content')
    <style>
        .auth-container {
            display: flex;
            min-height: 100vh;
        }

        .auth-left,
        .auth-right {
            flex: 1;
        }

        .auth-left {
            background: linear-gradient(to bottom right, #d32f2f, #f44336);
            color: white;
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .auth-left img {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            height: 85%;
            width: auto;
            object-fit: contain;
        }

        .auth-right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: #fafafa;
        }

        .form-wrapper {
            width: 100%;
        }
    </style>

    <div class="auth-container">

        <div class="auth-left">
            <img src="{{ asset('images/doctors_login.png') }}" alt="Doctors">
        </div>

        <div class="auth-right">
            <div class="form-wrapper">
                <main>
                    @yield('sub_content')
                </main>
            </div>
        </div>

    </div>
@endsection
