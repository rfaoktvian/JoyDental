@extends('layouts.app')

@section('content')
    @php
        use Illuminate\Support\Carbon;

        $today = ucfirst(Carbon::now()->locale('id')->translatedFormat('l'));
        $timeNow = Carbon::now();
    @endphp

    <style>
        .custom_card {
            background-color: #fff;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
        }

        .custom_card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .btn-outline-secondary i {
            pointer-events: none;
        }

        .btn-outline-danger {
            border-width: 1.5px;
        }

        .btn-outline-secondary {
            border-radius: 6px;
        }

        .review-item {
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .review-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .list-group-item {
            background-color: #fff;
        }
    </style>

    <div class="banner d-flex justify-content-center align-items-center text-center text-white mb-2 rounded py-4 px-3"
        style="background: linear-gradient(135deg, #d32f2f, #f44336);">
        <div style="z-index: 2;">
            <h2 class="fw-bold mb-2">Daftar Dokter Kami</h2>
            <p class="mb-0">Tim medis profesional dan berdedikasi untuk kesehatan Anda.</p>
        </div>
    </div>

    <section class="container">
        <div class="row g-3">
            @foreach ($doctors as $doctor)
                <div class="col-md-4 col-sm-6">
                    <div class="custom_card text-center p-3 d-flex flex-column align-items-center h-100">
                        <div><img src="{{ asset('images/doctors_dashboard.png') }}" alt="{{ $doctor->name }}"
                                class="rounded-circle mb-3" width="80" height="80" style="object-fit: cover;">

                            <h5 class="fw-bold mb-1">Dr. {{ $doctor->name }}</h5>
                            <p class="text-muted mb-1">{{ $doctor->specialization }}</p>

                            @php
                                $todaySchedule = $doctor->schedules->firstWhere('day', $today);
                            @endphp

                            @if ($todaySchedule && $todaySchedule->polyclinic)
                                <p class="small text-muted mb-1">
                                    <i class="fas fa-hospital-alt text-danger me-1"></i>
                                    {{ $todaySchedule->polyclinic->name }}
                                </p>

                                @php
                                    $start = Carbon::parse($todaySchedule->time_from);
                                    $end = Carbon::parse($todaySchedule->time_to);
                                    $isActive = $timeNow->between($start, $end);
                                @endphp

                                <p class="small {{ $isActive ? 'text-success fw-semibold' : 'text-muted' }}">
                                    {{ $today }}, {{ $start->format('H:i') }} - {{ $end->format('H:i') }}
                                </p>
                            @else
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-ban text-secondary me-1"></i>
                                    Tidak praktik hari ini
                                </p>
                            @endif
                        </div>
                        <div class="mt-auto">
                            @if ($doctor->reviews->count())
                                <div class="mb-2 small text-warning">
                                    <i class="fas fa-star me-1"></i>
                                    {{ number_format($doctor->reviews->avg('rating'), 1) }} / 5
                                </div>
                            @endif
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-center gap-2">

                                @guest
                                    <a data-bs-toggle="modal" data-bs-target="#loginModal"
                                        class="btn btn-danger btn-sm w-100 fw-semibold rounded">
                                        Buat Janji Temu
                                    </a>
                                @else
                                    <a href="{{ route('janji-temu') }}"
                                        class="btn btn-danger btn-sm w-100 fw-semibold rounded">
                                        Buat Janji Temu
                                    </a>
                                @endguest
                                <button class="doctor-reviews-btn btn btn-outline-secondary btn-sm"
                                    data-modal-url="/doctor/{{ $doctor->id }}/reviews"
                                    data-modal-title="Hasil Review Pasien">
                                    <i class="fas fa-comment-dots"></i>
                                </button>

                                <button class="doctor-schedule-btn btn btn-outline-secondary btn-sm"
                                    data-modal-url="/doctor/{{ $doctor->id }}/schedule" data-modal-title="Jadwal Dokter">
                                    <i class="fas fa-calendar-alt"></i>
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    </section>

    @include('partials.modal-loader')
@endsection
