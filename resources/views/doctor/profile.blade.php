@extends('layouts.app')

@section('content')

    <style>
        .bg-danger {
            --bs-bg-opacity: 1;
            background-color: #6b2c91 !important;
        }
    </style>

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
                    <div class="card-body text-center position-relative">
                        <button class="btn btn-sm btn-outline-primary position-absolute top-0 end-0 m-2"
                            data-modal-url="/doctor/{{ $doctor->id ?? 0 }}/edit" data-modal-title="Edit Profil Dokter">
                            <i class="fas fa-edit"></i>
                        </button>
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

                        <div class="d-flex align-items-center mb-1">
                            <span class="small">{{ optional($user)->description ?? '-' }}</span>
                        </div>
                        <div class="text-start">
                            <h6 class="fw-semibold mb-2">Kontak</h6>
                            <div class="d-flex align-items-center mb-1">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-envelope text-muted me-2"></i>
                                    <span class="small">{{ optional($user)->email ?? '-' }}</span>
                                </div>
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
                        <button class="btn btn-sm btn-outline-light"
                            data-modal-url="/doctor/{{ $doctor->id ?? 0 }}/reviews" data-modal-title="Hasil Review Pasien">
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
                <div class="card shadow-sm bg-white border border-1 border-mute">
                    <div
                        class="card-header bg-danger text-white fw-semibold d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-star me-2"></i> Ulasan Pasien
                        </span>
                    </div>
                    <div class="card-body">
                        @forelse (optional($doctor)->reviews?->take(5) ?? [] as $review)
                            <div class="mb-3">
                                <div class="fw-semibold">{{ optional($review->user)->name ?? 'Pasien Anonim' }}</div>
                                <div class="text-warning mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                    @endfor
                                </div>
                                <p class="small text-muted">{{ $review->comment ?? '-' }}</p>
                                <hr>
                            </div>
                        @empty
                            <div class="text-muted">Belum ada ulasan pasien.</div>
                        @endforelse
                    </div>
                </div>

                <div class="card shadow-sm bg-white border border-1 border-mute mt-4">
                    <div
                        class="card-header bg-danger text-white fw-semibold d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-calendar-alt me-2"></i> Janji Temu Terbaru
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Pasien</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($doctor)
                                    @forelse ($doctor->appointments()->latest()->take(5)->get() as $appt)
                                        <tr>
                                            <td>{{ optional($appt->user)->name ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($appt->appointment_date)->translatedFormat('d M Y') }}
                                            </td>
                                            <td>
                                                @if ($appt->status == 1)
                                                    <span class="badge bg-primary"><i
                                                            class="fas fa-clock me-1"></i>Upcoming</span>
                                                @elseif ($appt->status == 2)
                                                    <span class="badge bg-success"><i
                                                            class="fas fa-check me-1"></i>Completed</span>
                                                @else
                                                    <span class="badge bg-secondary"><i
                                                            class="fas fa-times me-1"></i>Cancelled</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted text-center">Belum ada janji temu.</td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="3" class="text-muted text-center">Dokter tidak ditemukan.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('partials.modal-loader')
@endsection
