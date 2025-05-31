<form method="POST" action="{{ route('admin.users.store') }}" id="tambahAkun-userForm">

    @csrf

    <div class="mb-2">
        <label for="nik" class="form-label">NIK</label>
        <input id="tambahAkun-nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik"
            value="{{ old('nik') }}" required placeholder="Masukkan NIK" maxlength="16">

        <div id="nik-error" class="text-danger small d-none">
        </div>
    </div>

    <div class="mb-2">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input id="tambahAkun-name" type="text" class="form-control @error('name') is-invalid @enderror"
            name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap" disabled>
    </div>

    <div class="mb-2">
        <label for="email" class="form-label">Email</label>
        <input id="tambahAkun-email" type="email" class="form-control @error('email') is-invalid @enderror"
            name="email" value="{{ old('email') }}" required placeholder="Masukkan email" disabled>
    </div>

    <div class="mb-2">
        <label for="password" class="form-label">Password</label>
        <input id="tambahAkun-password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" required autocomplete="new-password" placeholder="Masukkan password" disabled>
    </div>

    <div id="tambahAkun-form-error" class="text-danger small mb-3 d-none"></div>

    <button id="tambahAkun-submit" type="submit" class="btn btn-danger w-100 mt-1" disabled>
        Daftar
    </button>
</form>

<script>
    console.log('Add User Form script loaded');
    const form = document.getElementById('tambahAkun-userForm');
    const nikInput = document.getElementById('tambahAkun-nik');
    const nameInput = document.getElementById('tambahAkun-name');
    const emailInput = document.getElementById('tambahAkun-email');
    const passwordInput = document.getElementById('tambahAkun-password');
    const submitBtn = document.getElementById('tambahAkun-submit');
    const formError = document.getElementById('tambahAkun-form-error');
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
        passwordInput.value = '';

        nameInput.disabled = true;
        emailInput.disabled = true;
        passwordInput.disabled = true;
        submitBtn.disabled = true;
    }

    function enableAllFields() {
        nameInput.disabled = false;
        emailInput.disabled = false;
        passwordInput.disabled = false;
        submitBtn.disabled = false;
        checkSubmitReady();
    }

    function checkSubmitReady() {
        if (
            nikIsUnused &&
            nameInput.value.trim().length > 0 &&
            emailInput.value.trim().length > 0 &&
            passwordInput.value.length >= 6
        ) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    nikInput.addEventListener('input', () => {
        recheckNik();
    });

    [nameInput, emailInput, passwordInput].forEach(el => {
        el.addEventListener('input', () => {
            formError.classList.add('d-none');
            checkSubmitReady();
        });
    });

    document.getElementById('tambahAkun-userForm').addEventListener('submit', e => {
        if (submitBtn.disabled) {
            e.preventDefault();
        }
    });

    disableAllFields();
</script>

<script>
    function closeModalAndReload(evt) {
        document.body.classList.remove('modal-open');

        const modalEl = document.getElementById('commonModal');
        if (modalEl) {
            modalEl.classList.remove('show');
            modalEl.style.display = 'none';
            modalEl.setAttribute('aria-hidden', 'true');
        }

        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        window.location.reload();
    }
</script>
