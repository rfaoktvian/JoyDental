<form method="POST" action="{{ route('admin.dokter.update', ['id' => $doctor->id]) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label fw-semibold">Nama</label>
        <input type="text" class="form-control" name="name" value="{{ $doctor->user['name'] ?? $doctor->name }}"
            required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" class="form-control" name="email" value="{{ $doctor->user['email'] ?? '' }}" required>
    </div>

    {{-- Role hidden --}}
    <input type="hidden" name="role" value="doctor">

    <hr class="my-3">
    <h5 class="fw-bold mb-2">Jadwal Dokter</h5>

    {{-- Tabs for Days --}}
    <ul class="nav nav-tabs mb-3" id="dayTab" role="tablist">
        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ strtolower($day) }}"
                    data-bs-toggle="tab" data-bs-target="#content-{{ strtolower($day) }}" type="button" role="tab">
                    {{ $day }}
                </button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content" id="dayTabContent">
        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
            @php
                $schedule = $doctor->schedules->firstWhere('day', $day);
            @endphp
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-{{ strtolower($day) }}"
                role="tabpanel">
                <div class="mb-2">
                    <label class="form-label fw-semibold">Status Aktif</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="schedules[{{ $day }}][active]"
                            {{ $schedule ? 'checked' : '' }}>
                        <label class="form-check-label">Aktif</label>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label">Waktu Mulai</label>
                    <input type="time" class="form-control" name="schedules[{{ $day }}][time_from]"
                        value="{{ $schedule ? substr($schedule->time_from, 0, 5) : '' }}">
                </div>
                <div class="mb-2">
                    <label class="form-label">Waktu Selesai</label>
                    <input type="time" class="form-control" name="schedules[{{ $day }}][time_to]"
                        value="{{ $schedule ? substr($schedule->time_to, 0, 5) : '' }}">
                </div>
                <div class="mb-2">
                    <label class="form-label">Kapasitas Maksimal</label>
                    <input type="number" class="form-control" name="schedules[{{ $day }}][max_capacity]"
                        value="{{ $schedule->max_capacity ?? '' }}">
                </div>
                <div class="mb-2">
                    <label class="form-label">Poliklinik ID</label>
                    <input type="number" class="form-control" name="schedules[{{ $day }}][polyclinic_id]"
                        value="{{ $schedule->polyclinic_id ?? '' }}">
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex gap-2 justify-content-end">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger">Simpan</button>
    </div>
</form>

<hr class="my-3">
<form action="{{ route('admin.dokter.destroy', ['id' => $doctor->id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger w-100">
        <i class="fas fa-trash me-2"></i> Hapus Akun
    </button>
</form>
