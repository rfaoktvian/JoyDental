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

    {{-- 1) Beri ID pada form supaya script bisa menargetkannya  --}}
    <form id="registerForm" method="POST" action="{{ route('register') }}">
        @csrf

        {{-- 2) Bagian NIK --}}
        <div class="mb-2">
            <label for="nik" class="form-label">NIK</label>
            <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik"
                value="{{ old('nik') }}" required placeholder="Masukkan NIK" maxlength="16">
            @error('nik')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            {{-- 3) Tambahkan container untuk error pesan (initially hidden) --}}
            <div id="nik-error" class="text-danger small d-none">
                {{-- Konten akan di‐update oleh JavaScript --}}
            </div>
        </div>

        {{-- 4) Nama Lengkap --}}
        <div class="mb-2">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" required placeholder="Masukkan nama lengkap" disabled>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 5) Email --}}
        <div class="mb-2">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required placeholder="Masukkan email" disabled>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 6) Password --}}
        <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password" placeholder="Masukkan password" disabled>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 7) Konfirmasi Password --}}
        <div class="mb-4">
            <label for="password-confirm" class="form-label">Konfirmasi Password</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password" placeholder="Masukkan ulang password" disabled>
        </div>

        {{-- 8) Tombol “Daftar” beri ID supaya bisa di‐enable/disable lewat JS --}}
        <button id="register-submit" type="submit" class="btn btn-danger w-100" disabled>
            Daftar
        </button>
    </form>

    <script>
        console.log('Register form script loaded');
        document.addEventListener('DOMContentLoaded', () => {
            const nikInput = document.getElementById('nik');
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const pwdInput = document.getElementById('password');
            const confirmInput = document.getElementById('password-confirm');
            const submitBtn = document.getElementById('register-submit');
            const nikErrorDiv = document.getElementById('nik-error');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const checkNikUrl = "{{ route('check.nik') }}"; // Route yang memeriksa NIK

            // Flag untuk menandai apakah NIK belum terpakai dan valid
            let nikIsUnused = false;

            async function recheckNik() {
                const val = nikInput.value.trim();
                nikErrorDiv.classList.add('d-none');
                nikErrorDiv.textContent = '';
                nikIsUnused = false;

                // Jika kosong atau belum 16 digit, jangan panggil endpoint
                if (val.length === 0) {
                    disableAllFields();
                    return;
                }
                if (val.length !== 16 || !/^\d+$/.test(val)) {
                    disableAllFields();
                    nikErrorDiv.textContent = 'NIK harus berupa 16 digit angka.';
                    nikErrorDiv.classList.remove('d-none');
                    return;
                }

                // Coba fetch ke endpoint pengecekan NIK
                try {
                    const res = await fetch(`${checkNikUrl}?nik=${encodeURIComponent(val)}`, {
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (res.status === 404) {
                        // 404 → NIK tidak ketemu di DB → artinya “belum terpakai”
                        nikIsUnused = true;
                        nikErrorDiv.classList.add('d-none');
                        enableAllFields();
                        nameInput.focus();
                    } else if (res.ok) {
                        // 200 → NIK ditemukan → artinya “sudah terdaftar”
                        disableAllFields();
                        nikErrorDiv.textContent = 'NIK sudah terdaftar. Silakan gunakan NIK lain.';
                        nikErrorDiv.classList.remove('d-none');
                    } else {
                        // Status lain (misalnya 500)
                        disableAllFields();
                        nikErrorDiv.textContent = 'Gagal memeriksa NIK. Silakan coba lagi.';
                        nikErrorDiv.classList.remove('d-none');
                    }
                } catch (err) {
                    disableAllFields();
                    nikErrorDiv.textContent = 'Gagal terhubung ke server.';
                    nikErrorDiv.classList.remove('d-none');
                }
            }

            // Pada awalnya, matikan semua input (selain NIK)
            function disableAllFields() {
                nameInput.value = '';
                emailInput.value = '';
                pwdInput.value = '';
                confirmInput.value = '';

                nameInput.disabled = true;
                emailInput.disabled = true;
                pwdInput.disabled = true;
                confirmInput.disabled = true;
                submitBtn.disabled = true;
            }

            // Jika NIK belum terpakai, aktifkan semua field lain dulu
            function enableAllFields() {
                nameInput.disabled = false;
                emailInput.disabled = false;
                pwdInput.disabled = false;
                confirmInput.disabled = false;
                checkSubmitReady();
            }

            // Cek apakah tombol Daftar bisa di‐enable (semua field wajib terisi & nikIsUnused true)
            function checkSubmitReady() {
                if (
                    nikIsUnused &&
                    nameInput.value.trim().length > 0 &&
                    emailInput.value.trim().length > 0 &&
                    pwdInput.value.length >= 6 &&
                    (pwdInput.value === confirmInput.value)
                ) {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            }

            // Event: setiap input di NIK lakukan pengecekan ulang
            nikInput.addEventListener('input', () => {
                recheckNik();
            });

            // Jika user mengetik di field lain, cek kembali kesiapan tombol Daftar
            [nameInput, emailInput, pwdInput, confirmInput].forEach(el => {
                el.addEventListener('input', () => {
                    nikErrorDiv.classList.add('d-none');
                    checkSubmitReady();
                });
            });

            // Ketika form di‐submit, biarkan Laravel menangani validasi di server
            document.getElementById('registerForm').addEventListener('submit', e => {
                // Kalau tombol masih disable, cegah submit
                if (submitBtn.disabled) {
                    e.preventDefault();
                }
            });

            // Di‐load pertama kali, matikan semua
            disableAllFields();
        });
    </script>
@endsection
