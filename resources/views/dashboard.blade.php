@extends('layouts.app')

@section('content')
    <style>
        .doctor-card {
            transition: box-shadow 0.2s ease, transform 0.2s ease;
            background: #fff;
            border-radius: 10px;
        }

        .doctor-card:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
            transform: translateY(-3px);
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.3em 0.6em;
        }
    </style>

    <div class="banner position-relative p-4 rounded text-white d-flex align-items-center justify-content-between overflow-hidden"
        style="background: linear-gradient(135deg, #d32f2f, #f44336); height: 250px;">
        <div style="z-index: 2; max-width: 60%;">
            <h2>Daftar Antrian Lebih Mudah</h2>
            <h6 class="fw-light">
                AppointDoc membantu Anda menemukan dan menjadwalkan<br>
                konsultasi dengan dokter profesional di RS Siaga Sedia.
            </h6><br>
            <h5>Semoga anda lekas sembuh</h5>
        </div>
        <img src="{{ asset('images/doctors_dashboard.png') }}" alt="Doctors" class="imgdashboard"
            style="max-height: 100%; object-fit: contain;" />
    </div>

    <div class="border-bottom mb-3 mt-3"></div>

    <div class="container" style="max-width: 1320px;">
        <div class="row gx-4 gy-4">
            <div class="col-xl-8">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="custom_card p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="mb-0">Janji Temu Mendatang</h2>
                                <a href="tiket.html">Lihat Semua</a>
                            </div>
                            <div class="upcoming-appointment text-center py-4">
                                <img src="" alt="No appointments" class="mb-3">
                                <h3>Belum ada janji temu mendatang</h3>
                                <p class="text-muted">Jadwalkan konsultasi dengan dokter sekarang</p>
                            </div>
                        </div>
                    </div>

                    @php
                        use Illuminate\Support\Carbon;

                        $today = ucfirst(Carbon::now()->locale('id')->translatedFormat('l'));
                        $timeNow = Carbon::now();
                    @endphp

                    <div class="col-12">
                        <div class="custom_card p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="mb-0 fs-5">Dokter Rekomendasi</h2>
                                <a href="{{ route('dokter') }}" class="text-danger small">Lihat Semua</a>
                            </div>

                            <div class="row g-3">
                                @foreach ($doctors as $data)
                                    @php
                                        $todaySchedule = $data->schedules->firstWhere('day', $today);
                                        $start = $todaySchedule
                                            ? \Carbon\Carbon::parse($todaySchedule->time_from)
                                            : null;
                                        $end = $todaySchedule ? \Carbon\Carbon::parse($todaySchedule->time_to) : null;
                                        $isActive = $todaySchedule ? $timeNow->between($start, $end) : false;

                                        $rating = $data->reviews->avg('rating') ?? 0;
                                        $ratingFormatted = number_format($rating, 1);
                                        $badge =
                                            $poliklinikTypes[$data->schedules->first()->polyclinic->type ?? 1] ?? null;
                                    @endphp
                                    <div class="col-12">
                                        <div
                                            class="doctor-card border rounded shadow-sm p-3 d-md-flex align-items-center justify-content-between gap-2">
                                            <div class="d-flex gap-3 align-items-center">
                                                <img src="{{ asset('images/doctors_dashboard.png') }}"
                                                    class="rounded-circle" width="64" height="64"
                                                    style="object-fit: cover;">
                                                <div>
                                                    <h6 class="fw-bold mb-1 mb-md-0">Dr. {{ $data->name }}</h6>
                                                    <small class="text-muted d-block">
                                                        {{ $data->specialization }} | 10 tahun pengalaman
                                                    </small>
                                                    @if ($badge)
                                                        <span class="badge {{ $badge['class'] }} mt-1">
                                                            {{ $badge['label'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="text-muted small text-center text-md-start">
                                                @if ($todaySchedule)
                                                    <div><i class="fas fa-calendar-alt me-1"></i>{{ $today }}</div>
                                                    <div><i class="fas fa-clock me-1"></i>{{ $start->format('H:i') }} -
                                                        {{ $end->format('H:i') }}</div>
                                                @else
                                                    <div class="text-muted"><i class="fas fa-ban me-1"></i> Tidak praktik
                                                        hari ini</div>
                                                @endif
                                            </div>

                                            <div class="text-warning small text-center text-md-start">
                                                <i class="fas fa-star me-1"></i>{{ $ratingFormatted }} / 5
                                            </div>

                                            <div class="d-flex gap-2 justify-content-md-end mt-3 mt-md-0">
                                                @guest
                                                    <a data-bs-toggle="modal" data-bs-target="#loginModal"
                                                        class="btn btn-danger btn-sm">
                                                        Buat Janji Temu
                                                    </a>
                                                @else
                                                    <a href="#" class="btn btn-danger btn-sm">Buat Janji
                                                        Temu</a>
                                                @endguest
                                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#reviewModal-{{ $data->id }}">
                                                    <i class="fas fa-comment-dots"></i>
                                                </button>
                                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#scheduleModal-{{ $data->id }}">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </button>


                                            </div>
                                        </div>
                                    </div>

                                    @include('partials.review-modal', [
                                        'id' => $data->id,
                                        'name' => $data->name,
                                        'reviews' => $data->reviews,
                                    ])

                                    @include('partials.schedule-modal', [
                                        'id' => $data->id,
                                        'name' => $data->name,
                                        'schedules' => $data->schedules,
                                        'today' => $today,
                                    ])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="custom_card p-3 mb-4">
                    @include('partials.calendar', ['calendarId' => 'dashboard'])
                </div>

                <div class="custom_card p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="mb-0 fs-5">Daftar Poliklinik</h2>
                        <a href="{{ route('poliklinik') }}" class="text-danger small">Lihat Semua</a>
                    </div>

                    <div class="polyclinic-list">
                        @foreach ($polyclinics as $data)
                            @php
                                $badge = $poliklinikTypes[$data['type']];
                            @endphp

                            <div
                                class="d-flex align-items-center gap-2 px-2 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="rounded d-flex justify-content-center align-items-center bg-danger text-white"
                                    style="width: 40px; height: 40px; font-size: 1.1rem;">
                                    <i class="fas {{ $badge['icon'] }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $data['name'] }}</div>
                                    <div class="text-muted small">{{ $data['location'] }}</div>
                                </div>
                                <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
