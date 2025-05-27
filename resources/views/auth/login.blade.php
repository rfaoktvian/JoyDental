@extends('layouts.auth')

@section('sub_content')
    <div class="d-flex justify-content-end">
        <a href="{{ route('dashboard') }}" class="btn-close" aria-label="Close"></a>
    </div>

    <h2 class="fw-bold text-center mb-2">Selamat Datang Kembali</h2>
    <p class="text-muted text-center mb-4">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-danger">Daftar</a>

    <form id="loginForm" method="POST"">
        @csrf

        <div class=" mb-2">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror"
                value="{{ old('nik') }}" required autocomplete="nik" autofocus>
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
    </p>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const nikInput = document.getElementById('nik');
        const pwdInput = document.getElementById('password');
        const submitBtn = document.getElementById('login-submit');
        const formError = document.getElementById('form-error');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const checkNikUrl = "{{ route('check.nik') }}";

        let nikIsValid = false;

        async function recheckNik() {
            const val = nikInput.value.trim();

            formError.classList.add('d-none');
            formError.textContent = '';
            pwdInput.value = '';
            pwdInput.disabled = true;
            submitBtn.disabled = true;
            nikIsValid = false;

            if (val.length === 0) {
                return;
            }
            if (val.length != 16) {
                formError.textContent = 'NIK harus 16 digit.';
                formError.classList.remove('d-none');
                return;
            }
            try {
                const res = await fetch(`${checkNikUrl}?nik=${encodeURIComponent(val)}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                if (res.ok) {
                    nikIsValid = true;
                    pwdInput.disabled = false;
                    pwdInput.focus();
                } else {
                    formError.textContent = 'NIK tidak terdaftar.';
                    formError.classList.remove('d-none');
                }
            } catch {
                formError.textContent = 'Gagal memeriksa NIK.';
                formError.classList.remove('d-none');
            }
        }

        nikInput.addEventListener('input', recheckNik);

        nikInput.addEventListener('input', () => {
            if (pwdInput.value.length > 0) {
                pwdInput.value = '';
            }
        });

        pwdInput.addEventListener('input', () => {
            submitBtn.disabled = !(nikIsValid && pwdInput.value.length > 0);
        });

        document.getElementById('loginForm').addEventListener('submit', async e => {
            e.preventDefault();
            formError.classList.add('d-none');
            formError.textContent = '';

            const orig = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Memuat…';

            try {
                const res = await fetch("{{ route('login') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: new FormData(e.target)
                });
                if (res.ok) {
                    window.location.href = "{{ session()->pull('url.intended', url('/')) }}";
                    return;
                }
                formError.textContent = res.status === 422 ?
                    'NIK atau kata sandi salah.' :
                    'Terjadi kesalahan.';
            } catch {
                formError.textContent = 'Gagal terhubung ke server.';
            } finally {
                formError.classList.remove('d-none');
                submitBtn.disabled = false;
                submitBtn.textContent = orig;
            }
        });
    });
</script>
