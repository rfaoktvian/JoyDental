@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <div class="auth-container">

        {{-- Left Panel --}}
        <div class="auth-left">
            <img src="{{ asset('images/doctors_login.png') }}" alt="Doctors">
        </div>

        {{-- Right Panel --}}
        <div class="auth-right">
            <div class="form-wrapper">

                <h2 class="fw-bold text-center mb-2">Daftar Akun Baru</h2>
                <p class="text-muted text-center mb-4">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-danger">Log in</a>
                </p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- NIK --}}
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik"
                            value="{{ old('nik') }}" required placeholder="Masukkan NIK">
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required placeholder="Masukkan nama lengkap">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required placeholder="Masukkan email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="row mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="col-md-6">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password" placeholder="Masukkan password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="row mb-4">
                        <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password" placeholder="Masukkan ulang password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-danger w-100">
                        Daftar
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection