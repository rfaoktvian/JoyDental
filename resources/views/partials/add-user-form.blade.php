<form method="POST" action="{{ route('admin.users.store') }}" hx-post="{{ route('admin.users.store') }}"
    hx-target="#reschedule-body" hx-swap="innerHTML" hx-trigger="submit" id="userForm">

    @csrf

    <div class="mb-3">
        <label for="nik" class="form-label fw-semibold">NIK</label>
        <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror"
            value="{{ old('nik') }}" required minlength="16" maxlength="16"
            data-unique-url="{{ route('check.nik') }}" autocomplete="off" autofocus>
        @error('nik')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="name" class="form-label fw-semibold">Nama</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name') }}" minlength="2" maxlength="255" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-semibold">Password</label>
        <input type="password" name="password" id="password"
            class="form-control @error('password') is-invalid @enderror" minlength="8" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
            minlength="8" required>
    </div>

    <div id="form-error" class="text-danger small mb-3 d-none"></div>

    <button type="submit" id="submit-btn" class="btn btn-primary">
        Simpan
    </button>
</form>

<script>
    console.log('Add User Form script loaded');
    const form = document.getElementById('userForm');
    const nikInput = document.getElementById('nik');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('submit-btn');
    const formError = document.getElementById('form-error');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Enable fields only after NIK validation
    [nameInput, emailInput, passwordInput, passwordConfirmInput].forEach(input => {
        input.disabled = true;
    });
    submitBtn.disabled = true;

    // NIK validation
    nikInput.addEventListener('blur', async function() {
        const nik = this.value.trim();
        formError.classList.add('d-none');

        if (nik.length !== 16) {
            formError.textContent = 'NIK harus 16 digit.';
            formError.classList.remove('d-none');
            return;
        }

        try {
            const response = await fetch(this.dataset.uniqueUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    nik: nik
                })
            });

            if (response.ok) {
                const data = await response.json();
                if (data.exists) {
                    formError.textContent = 'NIK sudah terdaftar.';
                    formError.classList.remove('d-none');
                } else {
                    // Enable other fields if NIK is valid
                    [nameInput, emailInput, passwordInput, passwordConfirmInput].forEach(
                        input => {
                            input.disabled = false;
                        });
                    nameInput.focus();
                }
            }
        } catch (error) {
            formError.textContent = 'Gagal memverifikasi NIK.';
            formError.classList.remove('d-none');
        }
    });

    // Form submission handler
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        submitBtn.disabled = true;
        submitBtn.innerHTML =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (response.ok) {
                window.location.href = "{{ route('admin.users') }}";
            } else {
                const errors = await response.json();
                if (response.status === 422) {
                    // Handle validation errors
                    Object.keys(errors.errors).forEach(field => {
                        const input = form.querySelector(`[name="${field}"]`);
                        const feedback = input.nextElementSibling;

                        input.classList.add('is-invalid');
                        if (feedback && feedback.classList.contains(
                                'invalid-feedback')) {
                            feedback.textContent = errors.errors[field][0];
                        }
                    });
                } else {
                    formError.textContent = errors.message || 'Terjadi kesalahan.';
                    formError.classList.remove('d-none');
                }
            }
        } catch (error) {
            formError.textContent = 'Gagal terhubung ke server.';
            formError.classList.remove('d-none');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Simpan';
        }
    });

    // Enable submit button when all fields are valid
    form.addEventListener('input', function() {
        const allValid = [nikInput, nameInput, emailInput, passwordInput, passwordConfirmInput]
            .every(input => input.checkValidity());
        submitBtn.disabled = !allValid;
    });
</script>
