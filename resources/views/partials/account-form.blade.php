<form hx-put="{{ route('admin.users.update', ['id' => $user->id]) }}" hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
    hx-swap="none" hx-on="htmx:afterRequest: closeModalAndReload()">
    <div class="mb-3">
        <label class="form-label fw-semibold">Nama</label>
        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
    </div>

    @if ($user->id !== auth()->id())
        <div class="mb-3">
            <label class="form-label fw-semibold">Role</label>
            <select class="form-select" name="role" required>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                <option value="doctor" {{ $user->role === 'doctor' ? 'selected' : '' }}>Doctor</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
    @else
        <input type="hidden" name="role" value="{{ $user->role }}">
    @endif

    <div class="d-flex gap-2 justify-content-end">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" class="btn btn-danger">Simpan</button>
    </div>
</form>

@if ($user->id !== auth()->id())
    <hr class="my-3">

    <form hx-delete="{{ route('admin.users.destroy', ['id' => $user->id]) }}"
        hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}' hx-swap="none"
        hx-on="htmx:afterRequest: closeModalAndReload()">
        <button type="submit" class="btn btn-outline-danger w-100" hx-confirm="Hapus akun ini?">
            <i class="fas fa-trash me-2"></i> Hapus Akun
        </button>
    </form>
@endif

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
