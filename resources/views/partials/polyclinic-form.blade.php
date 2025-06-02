<form method="POST" action="{{ route('admin.poliklinik.update', ['id' => $polyclinic->id]) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label fw-semibold">Nama Poliklinik</label>
        <input type="text" class="form-control" name="name" value="{{ $polyclinic->name }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Lokasi</label>
        <input type="text" class="form-control" name="location" value="{{ $polyclinic->location }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Kapasitas</label>
        <input type="number" class="form-control" name="capacity" value="{{ $polyclinic->capacity }}" required>
    </div>

    <div class="d-flex gap-2 justify-content-end">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" class="btn btn-danger">Simpan</button>
    </div>
</form>

<hr class="my-3">
<form action="{{ route('admin.poliklinik.destroy', ['id' => $polyclinic->id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger w-100">
        <i class="fas fa-trash me-2"></i> Hapus Poliklinik
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
