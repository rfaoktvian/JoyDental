@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/manager.css') }}">

    <div class="container">
        <div class="banner position-relative p-4 rounded text-white d-flex align-items-center justify-content-between overflow-hidden"
            style="background: linear-gradient(135deg, #d32f2f, #f44336); height: 250px;">
            <div style="z-index: 2; max-width: 60%;">
                <h2>Selamat Datang, {{ $doctorProfile?->name ?? $user->name }}</h2>
                <h6 class="fw-light">
                    Kelola jadwal, konsultasi, dan aktivitas dokter dengan mudah.
                </h6><br>
                <div class="mb-2">
                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                        <i class="fas fa-clock me-1"></i>{{ now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>
            </div>
            <img src="{{ asset('images/doctors_dashboard.png') }}" alt="Doctors" class="imgdashboard"
                style="max-height: 100%; object-fit: contain;" />
        </div>

        <div class="border-bottom mb-3 mt-3"></div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-muted small mb-1">Antrian Aktif</div>
                            <div class="fs-5 fw-bold">{{ $activeQueue }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-muted small mb-1">Konsultasi Hari Ini</div>
                            <div class="fs-5 fw-bold">{{ $appointmentsToday }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-muted small mb-1">Janji Temu Mendatang</div>
                            <div class="fs-5 fw-bold">{{ $upcomingAppointments }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-3"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-muted small mb-1">Jadwal Hari Ini</div>
                            <div class="fs-5 fw-bold">
                                @php
                                    $today = ucfirst(\Carbon\Carbon::now()->locale('id')->translatedFormat('l'));
                                    $todaySchedule = optional($doctorProfile)
                                        ->schedules?->where('day', $today)
                                        ->first();
                                @endphp
                                @if ($todaySchedule)
                                    {{ $todaySchedule->time_from }} - {{ $todaySchedule->time_to }}
                                @else
                                    <span class="text-muted">Tidak praktik</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card shadow-sm bg-white border border-1 border-mute mb-4">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-calendar-week me-2"></i> Jadwal Praktik Minggu Ini
                </div>
                <a href="{{ route('doctor.profile') }}" class="text-decoration-none small fw-semibold text-danger">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 bg-white">
                        <thead class="table-light">
                            <tr class="bg-white">
                                <th class="bg-white">Hari</th>
                                <th class="bg-white">Poliklinik</th>
                                <th class="bg-white">Jam Praktik</th>
                                <th class="bg-white">Kuota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse (collect($doctorProfile?->schedules) as $schedule)
                                <tr class="bg-white">
                                    <td class="bg-white">{{ $schedule->day }}</td>
                                    <td class="bg-white">{{ $schedule->polyclinic->name ?? '-' }}</td>
                                    <td class="bg-white">{{ \Carbon\Carbon::parse($schedule->time_from)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($schedule->time_to)->format('H:i') }}</td>
                                    <td class="bg-white">{{ $schedule->max_capacity }}</td>
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

        <div class="card shadow-sm bg-white border border-1 border-mute mb-4">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-users me-2"></i> Antrian Hari Ini
                </div>
                <a href="{{ route('doctor.antrian') }}" class="text-decoration-none small fw-semibold text-danger">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    @forelse ($todayAppointments as $appt)
                        @include('partials.ongoing_ticket-card', ['appt' => $appt])
                    @empty
                        <div class="text-center py-5 text-muted w-100">Tidak ada tiket hari ini…</div>
                    @endforelse
                </div>

                @if ($todayAppointments->hasPages())
                    <nav class="d-flex justify-content-center">
                        {{ $todayAppointments->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                    </nav>
                @endif
            </div>
        </div>

        <div class="card shadow-sm bg-white border border-1 border-mute mb-4">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-user-md me-2"></i> Konsultasi Terakhir
                </div>
                <a href="{{ route('doctor.riwayat') }}" class="text-decoration-none small fw-semibold text-danger">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @if ($recentConsultation)
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user me-2 text-muted fs-5"></i>
                                <div>
                                    <strong>Nama Pasien:</strong>
                                    <span class="fw-semibold text-dark">{{ $recentConsultation->user->name ?? '-' }}</span>
                                </div>
                            </div>
                        </li>
                        <li class="mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-stethoscope me-2 text-muted fs-5"></i>
                                <div>
                                    <strong>Diagnosa:</strong>
                                    <span
                                        class="fw-semibold text-dark">{{ $recentConsultation->diagnosis ?? 'Belum ada' }}</span>
                                </div>
                            </div>
                        </li>
                        <li class="mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-notes-medical me-2 text-muted fs-5"></i>
                                <div>
                                    <strong>Tindakan:</strong>
                                    <span
                                        class="fw-semibold text-dark">{{ $recentConsultation->treatment ?? 'Belum ada' }}</span>
                                </div>
                            </div>
                        </li>
                        <li class="mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-2 text-muted fs-5"></i>
                                <div>
                                    <strong>Tanggal:</strong>
                                    <span
                                        class="fw-semibold text-dark">{{ $recentConsultation->appointment_date->format('d M Y') }}</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                @else
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <div>Belum ada konsultasi terbaru.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('partials.modal-loader')
@endsection
