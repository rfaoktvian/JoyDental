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
    <div class="container">
        <div class="banner position-relative p-4 rounded text-white d-flex align-items-center justify-content-between overflow-hidden"
            style="background: linear-gradient(135deg, #6B2C91, #9B5FCB); height: 250px;">
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
        @php
            use Illuminate\Support\Carbon;
            $today = ucfirst(Carbon::now()->locale('id')->translatedFormat('l'));
        $timeNow = Carbon::now(); @endphp
        @if (Auth::check())
            <div class="container" style="max-width: 1320px;">
                <hr class="my-3" style="opacity: 0.1;">
                <div class="row gx-4 gy-4">
                    <div class="col-xl-8">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="custom_card shadow-sm bg-white border border-1 border-mute p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h2 class="mb-0 fs-5">Dokter Rekomendasi</h2>
                                        <a href="{{ route('dokter') }}" class="text-decoration-none text-danger small">Lihat
                                            Semua</a>
                                    </div>
                                    <div class="row g-3">
                                        @forelse ($appointments as $appt)
                                            @include('partials.ongoing_ticket-card', ['appt' => $appt])
                                        @empty
                                            <div class="text-center py-5 text-muted w-100">Tidak ada tiket…</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom_card shadow-sm bg-white border border-1 border-mute p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h2 class="mb-0 fs-5">Dokter Rekomendasi</h2>
                                        <a href="{{ route('dokter') }}" class="text-decoration-none text-danger small">Lihat
                                            Semua</a>
                                    </div>
                                    <div class="row g-3">
                                        @foreach ($doctors as $data)
                                            @php
                                                $todaySchedule = $data->schedules->firstWhere('day', $today);
                                                $start = $todaySchedule
                                                    ? \Carbon\Carbon::parse($todaySchedule->time_from)
                                                    : null;
                                                $end = $todaySchedule
                                                    ? \Carbon\Carbon::parse($todaySchedule->time_to)
                                                    : null;
                                                $isActive = $todaySchedule ? $timeNow->between($start, $end) : false;
                                                $rating = $data->reviews->avg('rating') ?? 0;
                                                $ratingFormatted = number_format($rating, 1);
                                                $badge =
                                                    $poliklinikTypes[
                                                        $data->schedules->first()->polyclinic->type ?? 1
                                                    ] ?? null;
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
                                                            <div><i class="fas fa-calendar-alt me-1"></i>{{ $today }}
                                                            </div>
                                                            <div><i
                                                                    class="fas fa-clock me-1"></i>{{ $start->format('H:i') }}
                                                                -
                                                                {{ $end->format('H:i') }}</div>
                                                        @else
                                                            <div class="text-muted"><i class="fas fa-ban me-1"></i> Tidak
                                                                praktik
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
                                                            <a href="{{ route('dokter') }}" class="btn btn-danger btn-sm">Buat
                                                                Janji
                                                                Temu</a>
                                                        @endguest
                                                        <button class="doctor-reviews-btn btn btn-outline-secondary btn-sm"
                                                            data-modal-url="/doctor/{{ $data->id }}/reviews"
                                                            data-modal-title="Hasil Review Pasien">
                                                            <i class="fas fa-comment-dots"></i>
                                                        </button>

                                                        <button class="doctor-schedule-btn btn btn-outline-secondary btn-sm"
                                                            data-modal-url="/doctor/{{ $data->id }}/schedule"
                                                            data-modal-title="Jadwal Dokter">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="custom_card shadow-sm bg-white border border-1 border-mute p-3 mb-4">
                            @include('partials.calendar', ['calendarId' => 'dashboard'])
                        </div>
                        <div class="custom_card shadow-sm bg-white border border-1 border-mute p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="mb-0 fs-5">Daftar Poliklinik</h2>
                                <a href="{{ route('poliklinik') }}" class="text-decoration-none text-danger small">Lihat
                                    Semua</a>
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
        @else
            <section class="container mt-4" id="Dokter">
                <h4 class="text-center fw-bold text-danger mb-4">Dokter Rekomendasi</h4>
                <div class="row g-3">
                    @foreach ($doctors as $doctor)
                        @php
                            $rating = $doctor->reviews->avg('rating') ?? 0;
                            $ratingFormatted = number_format($rating, 1);
                        @endphp
                        <div class="col-md-4">
                            <div class="doctor-card border rounded shadow-sm p-3 text-center">
                                <img src="{{ asset('images/doctors_dashboard.png') }}" class="rounded-circle mb-2"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                                <h6 class="fw-bold mb-1">Dr. {{ $doctor->name }}</h6>
                                <small class="text-muted">{{ $doctor->specialization }}</small>
                                <div class="text-warning mt-2">
                                    <i class="fas fa-star me-1"></i>{{ $ratingFormatted }} / 5
                                </div>
                                <a href="{{ route('dokter') }}" class="btn btn-sm btn-danger mt-2">Lihat Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="container mt-4" id="Poliklinik">
                <h4 class="text-center fw-bold text-danger mb-4">Daftar Poliklinik</h4>
                <div class="row g-3">
                    @foreach ($polyclinics as $clinic)
                        @php
                            $badge = $poliklinikTypes[$clinic->type] ?? null;
                        @endphp
                        <div class="col-md-4">
                            <div class="border rounded shadow-sm p-3 text-center bg-white">
                                <div class="mb-2">
                                    <i class="fas {{ $badge['icon'] ?? 'fa-hospital' }} fa-2x text-danger"></i>
                                </div>
                                <h6 class="fw-semibold">{{ $clinic->name }}</h6>
                                <p class="text-muted small mb-1">{{ $clinic->location ?? '-' }}</p>
                                @if ($badge)
                                    <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
            <section class="container mt-4" id="Layanan">
                <h4 class="text-center fw-bold text-danger mb-4">Kenapa Memilih AppointDoc?</h4>
                <div class="row text-center g-4">
                    <div class="col-md-4">
                        <div class="p-4 rounded shadow-sm bg-white border border-1 border-mute" style="background: #fff;">
                            <span class="mb-3 d-inline-block text-danger" style="font-size: 2.5rem;">
                                <i class="fas fa-bolt"></i>
                            </span>
                            <h6 class="fw-semibold">Pendaftaran Cepat & Mudah</h6>
                            <p class="text-muted small">Tanpa antre panjang, cukup daftar melalui sistem kami dari mana
                                saja.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 rounded shadow-sm bg-white border border-1 border-mute" style="background: #fff;">
                            <span class="mb-3 d-inline-block text-danger" style="font-size: 2.5rem;">
                                <i class="fas fa-user-md"></i>
                            </span>
                            <h6 class="fw-semibold">Dokter Profesional</h6>
                            <p class="text-muted small">Ditangani oleh dokter berpengalaman dan kompeten di bidangnya.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 rounded shadow-sm bg-white border border-1 border-mute" style="background: #fff;">
                            <span class="mb-3 d-inline-block text-danger" style="font-size: 2.5rem;">
                                <i class="fas fa-smile-beam"></i>
                            </span>
                            <h6 class="fw-semibold">Pelayanan Ramah</h6>
                            <p class="text-muted small">Kami mengutamakan kenyamanan pasien dengan pelayanan yang
                                bersahabat.</p>
                        </div>
                    </div>
                </div>
            </section>


            <section class="container mt-4" id="testimoni">
                <h4 class="mb-4 text-center fw-bold text-danger">Apa Kata Mereka Tentang AppointDoc?</h4>

                <style>
                    .carousel-control-prev,
                    .carousel-control-next {
                        width: 45px;
                        height: 45px;
                        background-color: #d32f2f;
                        border-radius: 50%;
                        opacity: 0.8;
                        top: 50%;
                        transform: translateY(-50%);
                    }

                    .carousel-control-prev:hover,
                    .carousel-control-next:hover {
                        opacity: 1;
                        background-color: #b71c1c;
                    }
                </style>

                <div class="row">
                    <div class="col-12 position-relative">
                        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($doctorReviews as $index => $review)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <div class="card mx-auto rounded shadow-sm bg-white border border-1 border-mute"
                                            style="max-width: 600px;">
                                            <div class="card-body text-center">
                                                <div class="mb-2">
                                                    <i class="fas fa-quote-left fa-2x text-danger"></i>
                                                </div>
                                                <p class="card-text text-muted mb-3">
                                                    {{ $review->comment ?? 'Tidak ada komentar.' }}
                                                </p>
                                                <div class="fw-semibold mb-1">
                                                    {{ optional($review->user)->name ?? 'Pasien Anonim' }}
                                                </div>
                                                <div class="text-warning mb-1">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                                    @endfor
                                                </div>
                                                <small class="text-muted">
                                                    — Dokter: {{ optional($review->doctor)->name ?? '-' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button class="carousel-control-prev d-flex align-items-center justify-content-center"
                                type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev"
                                style="left: 0;">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next d-flex align-items-center justify-content-center"
                                type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next"
                                style="right: 0;">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>

    @include('partials.modal-loader')
@endsection

@section('footer')
    <footer class="bg-danger text-white pt-4">
        <div class="custom-container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <h5 class="fw-semibold mb-3">Alamat</h5>
                    <p class="small">
                        Jl. DI Panjaitan No.128,<br>
                        Karangreja, Purwokerto Kidul,<br>
                        Kec. Purwokerto Sel., Kabupaten Banyumas,<br>
                        Jawa Tengah 53147
                    </p>
                    <div class="ratio ratio-4x3">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.270756540308!2d109.24651767363716!3d-7.4352630925755525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e655ea49d9f9885%3A0x62be0b6159700ec9!2sTelkom%20Purwokerto%20University!5e0!3m2!1sid!2sid!4v1743670629696!5m2!1sid!2sid"
                            class="w-100 h-100 border-0" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                <div class="col-md-4">
                    <h5 class="fw-semibold mb-3">Menu Utama</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <a href="{{ route('dashboard') }}" class="text-white text-decoration-none">Beranda</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('dokter') }}" class="text-white text-decoration-none">Dokter</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('poliklinik') }}" class="text-white text-decoration-none">Poliklinik</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('bantuan') }}" class="text-white text-decoration-none">Bantuan</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h5 class="fw-semibold mb-3">Hubungi Kami</h5>
                    <p class="small">Kami siap melayani Anda 24 jam dalam situasi darurat.</p>
                    <ul class="list-unstyled small">
                        <li class="d-flex align-items-start mb-2">
                            <span class="me-2 fs-5"><i class="fas fa-phone"></i></span>
                            <div>
                                <a class="text-white text-decoration-none">+62 123-456-78</a><br>
                                <small class="text-white-50">Instalasi Gawat Darurat</small>
                            </div>
                        </li>
                        <li class="d-flex align-items-start mb-2">
                            <span class="me-2 fs-5"><i class="fas fa-envelope"></i></span>
                            <div>
                                <a class="text-white text-decoration-none">admin@siagasedia.com</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-start mb-2">
                            <span class="me-2 fs-5"><i class="fas fa-comments"></i></span>
                            <div>
                                <a>+62 123-456-78</a><br>
                                <small class="text-white-50">Keluhan & Saran</small>
                            </div>
                        </li>
                        <li class="d-flex align-items-start">
                            <span class="me-2 fs-5"><i class="fas fa-clock"></i></span>
                            <div>
                                <span class="text-white">Waktu Layanan:</span><br>
                                <small class="text-white-50">Senin - Sabtu: 08:00 - 19:00</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <hr class="border-light my-4">

        <div class="text-center py-3 small">
            &copy; {{ date('Y') }} AppointDoc. Hak cipta dilindungi undang-undang.
        </div>
    </footer>
@endsection
