@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/manager.css') }}">
    <div class="banner position-relative p-4 rounded text-white d-flex align-items-center justify-content-between overflow-hidden"
        style="background: linear-gradient(135deg, #d32f2f, #f44336); height: 250px;">
        <div style="z-index: 2; max-width: 60%;">
            <h2>Selamat Datang,
                {{ $doctorProfile?->name ?? $user->name }}
            </h2>
            <h6 class="fw-light">
                Kelola jadwal, antrian pasien, dan konsultasi dengan mudah.<br>
                Berikan pelayanan terbaik untuk pasien Anda.
            </h6><br>
            <div class="mb-2">
                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                    <i class="fas fa-clock me-1"></i>{{ date('l, d F Y') }}
                </span>
            </div>
        </div>
        <img src="{{ asset('images/doctors_dashboard.png') }}" alt="Doctors" class="imgdashboard"
            style="max-height: 100%; object-fit: contain;" />
    </div>
    <div class="border-bottom mb-3 mt-3"></div>
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-0">Dashboard Dokter</h2>
            <small class="text-muted">Ikhtisar performa dan aktivitas dokter</small>
        </div>
        <div>
            <a href="#" class="btn btn-danger btn-sm">
                <i class="fas fa-plus"></i> Tambah Dokter
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                        style="width: 40px; height: 40px;">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Total Dokter</h6>
                        <h4 class="mb-0">{{ $doctorsCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                        style="width: 40px; height: 40px;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Janji Temu Hari Ini</h6>
                        <h4 class="mb-0">{{ $appointmentsToday }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-3"
                        style="width: 40px; height: 40px;">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Rating Rata-rata</h6>
                        <h4 class="mb-0">{{ number_format($averageRating, 1) }}/5</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">Aktivitas Dokter Terbaru</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Dokter</th>
                            <th>Spesialisasi</th>
                            <th>Poliklinik</th>
                            <th>Jadwal Hari Ini</th>
                            <th>Rating</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentDoctors as $doctor)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                            style="width: 32px; height: 32px;">
                                            <i class="fas fa-user-md"></i>
                                        </div>
                                        <span>{{ $doctor->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $doctor->specialization }}</td>
                                <td>{{ $doctor->schedules->first()?->polyclinic?->name ?? '-' }}</td>
                                <td>
                                    @php
                                        $today = ucfirst(\Carbon\Carbon::now()->locale('id')->translatedFormat('l'));
                                        $todaySchedule = $doctor->schedules->firstWhere('day', $today);
                                    @endphp
                                    @if ($todaySchedule)
                                        {{ $todaySchedule->time_from }} - {{ $todaySchedule->time_to }}
                                    @else
                                        <span class="text-muted">Tidak praktik</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        {{ number_format($doctor->reviews->avg('rating') ?? 0, 1) }}/5
                                    </span>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-outline-secondary btn-sm"
                                        data-modal-url="{{ route('admin.users') }}" data-modal-title="Detail Dokter">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                                    <div>Tidak ada data aktivitas dokter terbaru.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <p>
        @json($doctorsCount)
        @json($appointmentsToday)
        @json($averageRating)
        @json($recentDoctors)
    </p>

    @include('partials.modal-loader')
@endsection
