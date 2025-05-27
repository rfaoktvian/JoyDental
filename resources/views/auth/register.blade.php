@extends('layouts.auth')

@section('sub_content')
    <div class="d-flex justify-content-end">
        <a href="{{ route('dashboard') }}" class="btn-close" aria-label="Close"></a>
    </div>

    <h2 class="fw-bold text-center mb-2">Daftar Akun Baru</h2>
    <p class="text-muted text-center mb-4">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-danger">Masuk</a>
    </p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-2">
            <label for="nik" class="form-label">NIK</label>
            <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik"
                value="{{ old('nik') }}" required placeholder="Masukkan NIK">
            @error('nik')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" required placeholder="Masukkan nama lengkap">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required placeholder="Masukkan email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password" placeholder="Masukkan password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-4">
            <label for="password-confirm" class="form-label">Konfirmasi Password</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password" placeholder="Masukkan ulang password">
        </div>

        <button type="submit" class="btn btn-danger w-100">
            Daftar
        </button>
    </form>
@endsection
