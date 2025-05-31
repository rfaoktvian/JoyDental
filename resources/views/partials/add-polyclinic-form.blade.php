<form method="POST" action="{{ route('admin.users.store') }}" id="tambahPoliklinik-userForm">
    @csrf
    <div class="mb-2">
        <label for="nik" class="form-label">NIK</label>
        <input id="tambahPoliklinik-nik" type="text" class="form-control @error('nik') is-invalid @enderror"
            name="nik" value="{{ old('nik') }}" required placeholder="Masukkan NIK" maxlength="16">

        <div id="nik-error" class="text-danger small d-none">
        </div>
    </div>

    <div class="mb-2">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input id="tambahPoliklinik-name" type="text" class="form-control @error('name') is-invalid @enderror"
            name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap" disabled>
    </div>

    <div class="mb-2">
        <label for="email" class="form-label">Email</label>
        <input id="tambahPoliklinik-email" type="email" class="form-control @error('email') is-invalid @enderror"
            name="email" value="{{ old('email') }}" required placeholder="Masukkan email" disabled>
    </div>

    <div class="mb-2">
        <label for="password" class="form-label">Password</label>
        <input id="tambahPoliklinik-password" type="password"
            class="form-control @error('password') is-invalid @enderror" name="password" required
            autocomplete="new-password" placeholder="Masukkan password" disabled>
    </div>

    <div id="tambahPoliklinik-form-error" class="text-danger small mb-3 d-none"></div>

    <button id="tambahPoliklinik-submit" type="submit" class="btn btn-danger w-100 mt-1" disabled>
        Daftar
    </button>
</form>

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
