@extends('layouts.auth')

@section('sub_content')
    <div class="d-flex justify-content-end">
        <a href="{{ route('dashboard') }}" class="btn-close" aria-label="Close"></a>
    </div>

    <h2 class="fw-bold text-center mb-2">Selamat Datang Kembali</h2>
    <p class="text-muted text-center mb-4">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-danger">Daftar</a>
    </p>

    <form id="loginForm" method="POST">
        @csrf

        <div class="mb-2">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror"
                value="{{ old('nik') }}" maxlength="16" required autofocus>
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password"
                disabled>
        </div>

        <div id="form-error" class="text-danger small mb-3 d-none"></div>

        <button type="submit" id="login-submit" class="btn btn-danger w-100" disabled>
            Masuk
        </button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Grab references to the inputs/buttons
            const nikInput = document.getElementById('nik');
            const pwdInput = document.getElementById('password');
            const submitBtn = document.getElementById('login-submit');
            const formError = document.getElementById('form-error');

            // Ensure CSRF token is present
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            if (!csrfTokenMeta) {
                console.error(
                    'CSRF token meta tag not found. Make sure <meta name="csrf-token" content="{{ csrf_token() }}"> is in your layout head.'
                );
                return;
            }
            const csrfToken = csrfTokenMeta.content;
            const checkNikUrl = "{{ route('check.nik') }}";

            // Track whether the NIK has been validated by the server
            let nikIsValid = false;

            /**
             * Call the server to verify if this NIK is registered.
             * Enabled only when length == 16.
             */
            async function verifyNikWithServer(nikValue) {
                formError.classList.add('d-none');
                formError.textContent = '';

                // Disable everything until response comes back
                pwdInput.value = '';
                pwdInput.disabled = true;
                submitBtn.disabled = true;
                nikIsValid = false;

                try {
                    const res = await fetch(`${checkNikUrl}?nik=${encodeURIComponent(nikValue)}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (res.ok) {
                        // NIK exists
                        nikIsValid = true;
                        pwdInput.disabled = false;
                        pwdInput.focus();
                    } else {
                        // NIK not found
                        formError.textContent = 'NIK tidak terdaftar.';
                        formError.classList.remove('d-none');
                    }
                } catch (error) {
                    console.error('Error checking NIK:', error);
                    formError.textContent = 'Gagal memeriksa NIK.';
                    formError.classList.remove('d-none');
                }
            }

            /**
             * Single listener on NIK input: check length, show error if length != 16,
             * and only call verifyNikWithServer when length === 16.
             */
            nikInput.addEventListener('input', () => {
                const raw = nikInput.value.trim();
                formError.classList.add('d-none');
                formError.textContent = '';

                // Whenever NIK changes, reset password & submit state
                pwdInput.value = '';
                pwdInput.disabled = true;
                submitBtn.disabled = true;
                nikIsValid = false;

                if (raw.length === 0) {
                    // No input, no need to check
                    return;
                }

                if (raw.length !== 16) {
                    // Show length error
                    formError.textContent = 'NIK harus 16 digit.';
                    formError.classList.remove('d-none');
                    return;
                }

                // If length is exactly 16, call server to check registration
                verifyNikWithServer(raw);
            });

            /**
             * Enable submit button only when NIK has been validated and password length > 0
             */
            pwdInput.addEventListener('input', () => {
                if (nikIsValid && pwdInput.value.length > 0) {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            });

            /**
             * On form submit, send an AJAX POST to login route.
             */
            document.getElementById('loginForm').addEventListener('submit', async (e) => {
                e.preventDefault();

                formError.classList.add('d-none');
                formError.textContent = '';

                const originalButtonText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Memuat…';

                try {
                    const formData = new FormData(e.target);

                    const res = await fetch("{{ route('login') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    if (res.ok) {
                        // Redirect on successful login
                        window.location.href = "{{ session()->pull('url.intended', url('/')) }}";
                        return;
                    }

                    // If status is 422, likely validation failed (bad NIK or password)
                    formError.textContent = (res.status === 422) ?
                        'NIK atau kata sandi salah.' :
                        'Terjadi kesalahan.';
                } catch (error) {
                    console.error('Login error:', error);
                    formError.textContent = 'Gagal terhubung ke server.';
                } finally {
                    formError.classList.remove('d-none');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalButtonText;
                }
            });
        });
    </script>
@endsection
