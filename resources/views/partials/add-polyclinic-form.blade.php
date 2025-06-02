<form method="POST" action="{{ route('admin.poliklinik.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label fw-semibold">Nama Poliklinik</label>
        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required
            placeholder="Masukkan nama poliklinik">
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Lokasi</label>
        <input type="text" class="form-control" name="location" value="{{ old('location') }}" required
            placeholder="Masukkan lokasi">
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Kapasitas</label>
        <input type="number" class="form-control" name="capacity" value="{{ old('capacity') }}" required
            placeholder="Masukkan kapasitas">
    </div>

    <div class="d-flex gap-2 justify-content-end">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" class="btn btn-danger">Simpan</button>
    </div>
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
