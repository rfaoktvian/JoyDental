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

    <form id="registerForm" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-2">
            <label for="nik" class="form-label">NIK</label>
            <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik"
                value="{{ old('nik') }}" required placeholder="Masukkan NIK" maxlength="16">

            <div id="nik-error" class="text-danger small d-none">
            </div>
        </div>

        <div class="mb-2">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" required placeholder="Masukkan nama lengkap" disabled>
        </div>

        <div class="mb-2">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required placeholder="Masukkan email" disabled>
        </div>

        <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password" placeholder="Masukkan password" disabled>
        </div>

        <div class="mb-4">
            <label for="password-confirm" class="form-label">Konfirmasi Password</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password" placeholder="Masukkan ulang password" disabled>
        </div>

        <div id="form-error" class="text-danger small mb-3 d-none"></div>

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
            const formError = document.getElementById('form-error');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const checkNikUrl = "{{ route('check.nik') }}";

            let nikIsUnused = false;

            async function recheckNik() {
                const val = nikInput.value.trim();
                formError.classList.add('d-none');
                formError.textContent = '';
                nikIsUnused = false;

                if (val.length === 0) {
                    disableAllFields();
                    return;
                }
                if (val.length !== 16 || !/^\d+$/.test(val)) {
                    disableAllFields();
                    formError.textContent = 'NIK harus berupa 16 digit angka.';
                    formError.classList.remove('d-none');
                    return;
                }

                try {
                    const res = await fetch(`${checkNikUrl}?nik=${encodeURIComponent(val)}`, {
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (res.status === 404) {
                        nikIsUnused = true;
                        formError.classList.add('d-none');
                        enableAllFields();
                        nameInput.focus();
                    } else if (res.ok) {
                        disableAllFields();
                        formError.textContent = 'NIK sudah terdaftar. Silakan gunakan NIK lain.';
                        formError.classList.remove('d-none');
                    } else {
                        disableAllFields();
                        formError.textContent = 'Gagal memeriksa NIK. Silakan coba lagi.';
                        formError.classList.remove('d-none');
                    }
                } catch (err) {
                    disableAllFields();
                    formError.textContent = 'Gagal terhubung ke server.';
                    formError.classList.remove('d-none');
                }
            }

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

            function enableAllFields() {
                nameInput.disabled = false;
                emailInput.disabled = false;
                pwdInput.disabled = false;
                confirmInput.disabled = false;
                checkSubmitReady();
            }

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

            nikInput.addEventListener('input', () => {
                recheckNik();
            });

            [nameInput, emailInput, pwdInput, confirmInput].forEach(el => {
                el.addEventListener('input', () => {
                    formError.classList.add('d-none');
                    checkSubmitReady();
                });
            });

            document.getElementById('registerForm').addEventListener('submit', e => {
                // Kalau tombol masih disable, cegah submit
                if (submitBtn.disabled) {
                    e.preventDefault();
                }
            });

            disableAllFields();
        });
    </script>
@endsection
