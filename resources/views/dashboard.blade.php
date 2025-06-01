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
            <section class="container mt-4" id="Layanan">
                <h4 class="text-center fw-bold text-danger mb-4">Kenapa Memilih AppointDoc?</h4>
                <div class="row text-center g-4">

                    <!-- Keunggulan 1 -->
                    <div class="col-md-4">
                        <div class="p-4 border rounded shadow-sm h-100">
                            <img src="https://cdn-icons-png.flaticon.com/512/869/869636.png" alt="Cepat & Mudah"
                                width="60" class="mb-3">
                            <h6 class="fw-semibold">Pendaftaran Cepat & Mudah</h6>
                            <p class="text-muted small">Tanpa antre panjang, cukup daftar melalui sistem kami dari mana
                                saja.</p>
                        </div>
                    </div>

                    <!-- Keunggulan 2 -->
                    <div class="col-md-4">
                        <div class="p-4 border rounded shadow-sm h-100">
                            <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" alt="Dokter Profesional"
                                width="60" class="mb-3">
                            <h6 class="fw-semibold">Dokter Profesional</h6>
                            <p class="text-muted small">Ditangani oleh dokter berpengalaman dan kompeten di bidangnya.</p>
                        </div>
                    </div>

                    <!-- Keunggulan 3 -->
                    <div class="col-md-4">
                        <div class="p-4 border rounded shadow-sm h-100">
                            <img src="https://cdn-icons-png.flaticon.com/512/679/679922.png" alt="Pelayanan Ramah"
                                width="60" class="mb-3">
                            <h6 class="fw-semibold">Pelayanan Ramah</h6>
                            <p class="text-muted small">Kami mengutamakan kenyamanan pasien dengan pelayanan yang
                                bersahabat.</p>
                        </div>
                    </div>

                </div>
            </section>
            <section class="container mt-4" id="testimoni">
                <h4 class="mb-4 text-center fw-bold text-danger">Apa Kata Mereka Tentang AppointDoc?</h4>

                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel"
                    style="position: relative;">
                    <div class="carousel-inner">

                        <!-- Slide 1 -->
                        <div class="carousel-item active">
                            <div class="row g-4">
                                <!-- Testimoni 1 -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="doctors_login.png" class="rounded-circle me-3" alt="Rina"
                                                    width="40" height="40">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Rina</h6>
                                                    <small class="text-muted">34 tahun - Ibu Rumah Tangga</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>"Pelayanannya cepat, dokter ramah, dan sistemnya sangat membantu!"</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Testimoni 2 -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="doctors_login.png" class="rounded-circle me-3" alt="Budi"
                                                    width="40" height="40">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Budi</h6>
                                                    <small class="text-muted">40 tahun - Karyawan Swasta</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>"Saya bisa booking dokter dari rumah tanpa antri lama. Sangat efisien!"</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Testimoni 3 -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="doctors_login.png" class="rounded-circle me-3" alt="Sari"
                                                    width="40" height="40">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Sari</h6>
                                                    <small class="text-muted">28 tahun - Freelancer</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>"Platform ini membantu saya mendapatkan dokter yang tepat dengan cepat."</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="carousel-item">
                            <div class="row g-4">
                                <!-- Testimoni 4 -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="doctors_login.png" class="rounded-circle me-3" alt="Dewi"
                                                    width="40" height="40">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Dewi</h6>
                                                    <small class="text-muted">25 tahun - Mahasiswa</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>"Sangat terbantu dengan fitur antrian online, tidak perlu datang lebih awal."
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Testimoni 5 -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="doctors_login.png" class="rounded-circle me-3" alt="Andi"
                                                    width="40" height="40">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Andi</h6>
                                                    <small class="text-muted">31 tahun - Pegawai Negeri</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>"Saya suka desain aplikasinya, simpel dan mudah digunakan."</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Testimoni 6 -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="doctors_login.png" class="rounded-circle me-3" alt="Lina"
                                                    width="40" height="40">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Lina</h6>
                                                    <small class="text-muted">38 tahun - Ibu 2 Anak</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>"Dokternya profesional dan staffnya sangat membantu. Sangat recommended!"</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Carousel Controls: left and right side -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                        data-bs-slide="prev" style="left: -50px; top: 50%; transform: translateY(-50%);">
                        <span class="carousel-control-prev-icon bg-danger rounded-circle p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                        data-bs-slide="next" style="right: -50px; top: 50%; transform: translateY(-50%);">
                        <span class="carousel-control-next-icon bg-danger rounded-circle p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </section>

            <section class="container mt-4" id="testimoni">
                <h4 class="mb-4 text-center fw-bold text-danger">Apa Kata Mereka Tentang AppointDoc?</h4>

                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel"
                    style="position: relative;">
                    <div class="carousel-inner">

                        <!-- Slide 1 -->
                        <div class="carousel-item active">
                            <div class="row g-4">
                                <!-- Testimoni 1 -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="doctors_login.png" class="rounded-circle me-3" alt="Rina"
                                                    width="40" height="40">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Rina</h6>
                                                    <small class="text-muted">34 tahun - Ibu Rumah Tangga</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>"Pelayanannya cepat, dokter ramah, dan sistemnya sangat membantu!"</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Testimoni 2 -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="doctors_login.png" class="rounded-circle me-3" alt="Budi"
                                                    width="40" height="40">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Budi</h6>
                                                    <small class="text-muted">40 tahun - Karyawan Swasta</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>"Saya bisa booking dokter dari rumah tanpa antri lama. Sangat efisien!"</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Testimoni 3 -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="doctors_login.png" class="rounded-circle me-3" alt="Sari"
                                                    width="40" height="40">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Sari</h6>
                                                    <small class="text-muted">28 tahun - Freelancer</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>"Platform ini membantu saya mendapatkan dokter yang tepat dengan cepat."</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="carousel-item">
                            <div class="row g-4">
                                <!-- Testimoni 4 -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="doctors_login.png" class="rounded-circle me-3" alt="Dewi"
                                                    width="40" height="40">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Dewi</h6>
                                                    <small class="text-muted">25 tahun - Mahasiswa</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>"Sangat terbantu dengan fitur antrian online, tidak perlu datang lebih awal."
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Testimoni 5 -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="doctors_login.png" class="rounded-circle me-3" alt="Andi"
                                                    width="40" height="40">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Andi</h6>
                                                    <small class="text-muted">31 tahun - Pegawai Negeri</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>"Saya suka desain aplikasinya, simpel dan mudah digunakan."</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Testimoni 6 -->
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="doctors_login.png" class="rounded-circle me-3" alt="Lina"
                                                    width="40" height="40">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">Lina</h6>
                                                    <small class="text-muted">38 tahun - Ibu 2 Anak</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>"Dokternya profesional dan staffnya sangat membantu. Sangat recommended!"</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Carousel Controls: left and right side -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                        data-bs-slide="prev" style="left: -50px; top: 50%; transform: translateY(-50%);">
                        <span class="carousel-control-prev-icon bg-danger rounded-circle p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                        data-bs-slide="next" style="right: -50px; top: 50%; transform: translateY(-50%);">
                        <span class="carousel-control-next-icon bg-danger rounded-circle p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </section>

            <div class="py-4"></div>
        @endif
    </div>

    @include('partials.modal-loader')
@endsection

@section('footer')
    <footer class="bg-danger text-white pt-4">
        <div class="container">
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
                            <a href="#beranda" class="text-white text-decoration-none">Beranda</a>
                        </li>
                        <li class="mb-2">
                            <a href="#testimoni" class="text-white text-decoration-none">Testimoni</a>
                        </li>
                        <li class="mb-2">
                            <a href="#Layanan" class="text-white text-decoration-none">Layanan</a>
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
                                <a href="tel:+6212345678" class="text-white text-decoration-none">+62 123-456-78</a><br>
                                <small class="text-white-50">Instalasi Gawat Darurat</small>
                            </div>
                        </li>
                        <li class="d-flex align-items-start mb-2">
                            <span class="me-2 fs-5"><i class="fas fa-envelope"></i></span>
                            <div>
                                <a href="mailto:admin@siagasedia.com"
                                    class="text-white text-decoration-none">admin@siagasedia.com</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-start mb-2">
                            <span class="me-2 fs-5"><i class="fas fa-comments"></i></span>
                            <div>
                                <a href="tel:+6212345678" class="text-white text-decoration-none">+62 123-456-78</a><br>
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
