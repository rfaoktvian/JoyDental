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
                        <div class="position-relative">
                            <img src="{{ asset('images/doctors_login.png') }}" alt="Profile Photo"
                                class="rounded-circle shadow-sm border border-3 border-light mb-2"
                                style="width: 120px; height: 120px; object-fit: cover;" id="profilePhoto">
                        </div>
                        <h5 class="fw-bold mb-1">{{ $doctor->name ?? '-' }}</h5>
                        <p class="text-muted mb-2 fst-italic">{{ $doctor->specialization ?? '-' }}</p>

                        <div class="d-flex justify-content-center gap-3 mb-3">
                            <div>
                                <div class="fw-bold text-primary fs-5">{{ $completedSchedulesCount ?? 0 }}</div>
                                <small class="text-muted">Pasien</small>
                            </div>
                            <div class="vr"></div>
                            <div>
                                @php
                                    $registered = $doctor->registered ?? null;
                                    $experienceText = '-';
                                    if ($registered) {
                                        $start = \Carbon\Carbon::parse($registered);
                                        $now = now();
                                        $years = (int) $start->diffInYears($now);
                                        $months = (int) $start->copy()->addYears($years)->diffInMonths($now);
                                        $experienceText = $years > 0 ? $years : 0;
                                    }
                                @endphp
                                <div class="fw-bold text-success fs-5">{{ $experienceText }}</div>
                                <small class="text-muted">
                                    @if (isset($years) && $years > 0)
                                        Tahun
                                    @elseif(isset($months) && $months > 0)
                                        Bulan
                                    @else
                                        Tahun
                                    @endif
                                </small>
                            </div>
                            <div class="vr"></div>
                            <div>
                                <div class="fw-bold text-warning fs-5">{{ $averageRating ?? '-' }}</div>
                                <small class="text-muted">Rating</small>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="text-start">
                            <h6 class="fw-semibold mb-2">Kontak</h6>
                            <div class="d-flex align-items-center mb-1">
                                <i class="fas fa-envelope text-muted me-2"></i>
                                <span class="small">{{ optional($user)->email ?? '-' }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <i class="fas fa-phone text-muted me-2"></i>
                                <span class="small">{{ optional($user)->phone ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm bg-white border border-1 border-mute mb-4">
                    <div
                        class="card-header bg-danger text-white fw-semibold d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-calendar-week me-2"></i> Jadwal Praktik
                        </span>
                        <button class="btn btn-sm btn-outline-light" data-modal-url="/doctor/{{ $doctor->id ?? 0 }}/reviews"
                            data-modal-title="Hasil Review Pasien">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover mb-0 bg-white">
                            <thead class="table-light">
                                <tr class="bg-white">
                                    <th class="bg-white">Hari</th>
                                    <th class="bg-white">Poliklinik</th>
                                    <th class="bg-white">Jam Praktik</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (optional($doctorSchedules) as $schedule)
                                    <tr class="bg-white">
                                        <td class="bg-white">{{ $schedule->day ?? '-' }}</td>
                                        <td class="bg-white">{{ optional($schedule->polyclinic)->name ?? '-' }}</td>
                                        <td class="bg-white">
                                            {{ \Carbon\Carbon::parse($schedule->time_from ?? '00:00')->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($schedule->time_to ?? '00:00')->format('H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white">
                                        <td colspan="4" class="text-center text-muted py-4 bg-white">
                                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                                            <div>Tidak ada jadwal praktik terdaftar.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
            </div>
        </div>
    </div>
    @include('partials.modal-loader')
@endsection
