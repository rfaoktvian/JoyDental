@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold text-dark mb-1">Profil Dokter</h4>
                <p class="text-muted mb-0">Kelola informasi pribadi dan jadwal praktik</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4 d-flex flex-column gap-4">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body text-center">
                        <div class="position-relative mb-3">
                            <img src="{{ asset('images/doctors_login.png') }}" alt="Profile Photo"
                                class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;"
                                id="profilePhoto">
                            <button class="btn btn-sm btn-danger rounded-circle position-absolute"
                                style="bottom: 10px; right: calc(50% - 70px);" onclick="changePhoto()">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $doctor->name ?? 'Dr. Ahmad Susanto' }}</h5>
                        <p class="text-muted mb-3">{{ $doctor->specialization ?? 'Dokter Umum' }}</p>

                        <div class="row text-center">
                            <div class="col-4">
                                <div class="border-end">
                                    <h6 class="fw-bold text-primary mb-0">{{ $doctor->total_patients ?? 1247 }}</h6>
                                    <small class="text-muted">Pasien</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border-end">
                                    <h6 class="fw-bold text-success mb-0">{{ $doctor->experience ?? 8 }}</h6>
                                    <small class="text-muted">Tahun</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <h6 class="fw-bold text-warning mb-0">4.9</h6>
                                <small class="text-muted">Rating</small>
                            </div>
                        </div>

                        <hr>

                        <div class="text-start">
                            <h6 class="fw-bold mb-3">Informasi Kontak</h6>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-envelope text-muted me-3"></i>
                                <span>{{ $doctor->email ?? 'ahmad.susanto@email.com' }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-phone text-muted me-3"></i>
                                <span>{{ $doctor->phone ?? '+62 812-3456-7890' }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-id-card text-muted me-3"></i>
                                <span>{{ $doctor->license_number ?? 'SIP.123456789' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar text-muted me-3"></i>
                                <span>Bergabung {{ $doctor->joined_date ?? 'Jan 2020' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm bg-white border border-1 border-mute mb-4">
                    <div class="card-header bg-danger text-white fw-semibold">
                        <i class="fas fa-calendar-week me-2"></i> Jadwal Praktik
                    </div>
                    <div class="card-body">
                        <label for="polyclinic" class="form-label">Daftar Poliklinik <span
                                class="text-danger">*</span></label>
                        <select class="form-select @error('polyclinic') is-invalid @enderror" id="polyclinic"
                            name="polyclinic" required>
                            <option value="" disabled selected>Pilih Poliklinik</option>
                        </select>
                        <div class="form-text">Pilih poliklinik yang akan Anda kunjungi</div>
                        @error('polyclinic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="fw-bold mb-0">Informasi Pribadi</h6>
                        </div>
                        <div class="card-body">
                            <form id="profileForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Nama Lengkap *</label>
                                        <input type="text" class="form-control"
                                            value="{{ $doctor->name ?? 'Dr. Ahmad Susanto' }}" name="name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Spesialisasi *</label>
                                        <select class="form-select" name="specialization" required>
                                            <option value="Dokter Umum" selected>Dokter Umum</option>
                                            <option value="Dokter Anak">Dokter Anak</option>
                                            <option value="Dokter Kandungan">Dokter Kandungan</option>
                                            <option value="Dokter Jantung">Dokter Jantung</option>
                                            <option value="Dokter Mata">Dokter Mata</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Email *</label>
                                        <input type="email" class="form-control"
                                            value="{{ $doctor->email ?? 'ahmad.susanto@email.com' }}" name="email"
                                            required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Nomor Telepon *</label>
                                        <input type="tel" class="form-control"
                                            value="{{ $doctor->phone ?? '+62 812-3456-7890' }}" name="phone" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Nomor SIP *</label>
                                        <input type="text" class="form-control"
                                            value="{{ $doctor->license_number ?? 'SIP.123456789' }}" name="license_number"
                                            required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Pengalaman (Tahun)</label>
                                        <input type="number" class="form-control" value="{{ $doctor->experience ?? 8 }}"
                                            name="experience" min="0">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-semibold">Alamat</label>
                                        <textarea class="form-control" rows="3" name="address" placeholder="Masukkan alamat lengkap">{{ $doctor->address ?? 'Jl. Kesehatan No. 123, Jakarta Selatan, DKI Jakarta 12345' }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Bio/Deskripsi</label>
                                        <textarea class="form-control" rows="4" name="bio"
                                            placeholder="Ceritakan tentang diri Anda, pengalaman, dan keahlian">{{ $doctor->bio ?? 'Dokter umum berpengalaman dengan fokus pada pelayanan kesehatan primer dan pencegahan penyakit. Menangani berbagai kondisi medis dengan pendekatan holistik.' }}</textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">Jadwal Praktik</h6>
                            <button class="btn btn-sm btn-outline-danger" onclick="addSchedule()">
                                <i class="fas fa-plus me-1"></i>Tambah Jadwal
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="scheduleContainer">
                                <div class="row align-items-center mb-3 schedule-row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="monday" checked>
                                            <label class="form-check-label fw-semibold" for="monday">Senin</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="08:00" name="monday_start">
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <span class="text-muted">sampai</span>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="16:00" name="monday_end">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control" value="20" placeholder="Kuota"
                                            name="monday_quota">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="row align-items-center mb-3 schedule-row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="tuesday" checked>
                                            <label class="form-check-label fw-semibold" for="tuesday">Selasa</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="08:00" name="tuesday_start">
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <span class="text-muted">sampai</span>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="16:00" name="tuesday_end">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control" value="20" placeholder="Kuota"
                                            name="tuesday_quota">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="row align-items-center mb-3 schedule-row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="wednesday" checked>
                                            <label class="form-check-label fw-semibold" for="wednesday">Rabu</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="08:00"
                                            name="wednesday_start">
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <span class="text-muted">sampai</span>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="16:00" name="tuesday_end">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control" value="20" placeholder="Kuota"
                                            name="tuesday_quota">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="row align-items-center mb-3 schedule-row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="thursday" checked>
                                            <label class="form-check-label fw-semibold" for="thursday">Kamis</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="08:00" name="thursday_start">
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <span class="text-muted">sampai</span>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="16:00" name="thursday_end">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control" value="20" placeholder="Kuota"
                                            name="thursday_quota">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Friday -->
                                <div class="row align-items-center mb-3 schedule-row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="friday" checked>
                                            <label class="form-check-label fw-semibold" for="friday">Jumat</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="08:00" name="friday_start">
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <span class="text-muted">sampai</span>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="16:00" name="friday_end">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control" value="20" placeholder="Kuota"
                                            name="friday_quota">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Saturday -->
                                <div class="row align-items-center mb-3 schedule-row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="saturday">
                                            <label class="form-check-label fw-semibold" for="saturday">Sabtu</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="08:00" name="saturday_start"
                                            disabled>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <span class="text-muted">sampai</span>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="13:00" name="saturday_end"
                                            disabled>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control" value="15" placeholder="Kuota"
                                            name="saturday_quota" disabled>
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                            <i class="fas fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Sunday -->
                                <div class="row align-items-center mb-3 schedule-row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="sunday">
                                            <label class="form-check-label fw-semibold" for="sunday">Minggu</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="09:00" name="sunday_start"
                                            disabled>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <span class="text-muted">sampai</span>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" value="14:00" name="sunday_end"
                                            disabled>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control" value="10" placeholder="Kuota"
                                            name="sunday_quota" disabled>
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                            <i class="fas fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
