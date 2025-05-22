<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AppointDoc - Online Consultation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body>

  @include('partials.login-modal')

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-2" id="beranda">
    <div>
      <a class="navbar-brand d-flex align-items-center text-danger fw-bold fs-4" href="#">
        <i class="bi bi-heart-pulse-fill me-2"></i> AppointDoc
      </a>
      <span class="ms-5 text-black-50 fs-6 fst-italic subtitle">by RS Siaga Sedia</span>
    </div>

    <div class="ms-auto d-flex align-items-center gap-3">
      @guest
      <a href="#" class="btn btn-outline-danger px-4" data-bs-toggle="modal" data-bs-target="#loginModal">
      Login
      </a>
      <a href="register.html" class="btn btn-danger text-white px-4">
      Daftar
      </a>
    @endguest

      @auth
      <div class="dropdown">
      <a class="btn btn-outline-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        {{ Auth::user()->name }}
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('logout') }}"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          Logout
        </a></li>
      </ul>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
      </div>
    @endauth

    </div>
  </nav>

  <!-- BANNER -->
  <div class="container mt-3 position-relative">
    <div
      class="banner position-relative p-4 rounded text-white d-flex align-items-center justify-content-between overflow-hidden"
      style="background: linear-gradient(135deg, #d32f2f, #f44336); height: 250px;">
      <div style="z-index: 2; max-width: 60%;">
        <h2>Daftar Antrian Lebih Mudah</h2>
        <h6 class="fw-light">AppointDoc membantu Anda menemukan dan menjadwalkan <br>
          konsultasi dengan dokter profesional di RS Siaga Sedia.</h6><br>
        <h5>Semoga anda lekas sembuh</h5>
      </div>
      <img src="{{ asset('images/doctors_dashboard.png') }}" alt="Doctors" class="imgdashboard" />
    </div>

    <!-- Search Bar -->
    <div
      class="search-bar bg-white shadow-sm rounded-pill p-2 d-flex align-items-center justify-content-between mt-n4 position-relative mx-auto"
      style="max-width: 600px;">
      <input type="text" class="form-control border-0 rounded-pill me-2" placeholder="Pencarian Poliklinik" />
      <button class="btn btn-danger text-white rounded-pill px-4">Cari</button>
    </div>
  </div>


  <!-- RECOMENDED DOCTOR -->
  <section class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5>Daftar Poliklinik</h5>
      <a href="#" class="text-decoration-none text-danger">View All ></a>
    </div>
    <div class="row">
      <!-- Doctor Card -->
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/hospital.svg') }}" alt="Ikon Hospital" width="45" height="45"
                class="rounded-circle me-3 bg-danger">
              <div>
                <h6 class="mb-0">Klinik Anak</h6>
                <small>Gedung Cokro Aminoto Lt.3</small><br>
                <span class="badge bg-danger-subtle text-danger mt-1">Pediatric</span>
              </div>
            </div>
            <p class="mb-1">Senin, Rabu | 10:00 - 13:00</p>
            <p>Kapasitas: 23/30</p>
            <a href="login.html">
              <button class="btn btn-danger text-white w-100">Book an appointment</button>
            </a>

          </div>
        </div>
      </div>

      <!-- Repeat cards -->
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/hospital.svg') }}" alt="Ikon Hospital" width="45" height="45"
                class="rounded-circle me-3 bg-danger">
              <div>
                <h6 class="mb-0">Klinik Bedah Mulut Maksilofasial</h6>
                <small>Gedung Cokro Aminoto Lt.3</small><br />
                <span class="badge bg-info-subtle text-primary mt-1">Surgical</span>
              </div>
            </div>
            <p class="mb-1">Rabu, Jumat | 07:00 - 11:00</p>
            <p>Kapasitas: 2/15</p>
            <a href="login.html">
              <button class="btn btn-danger text-white w-100">Book an appointment</button>
            </a>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/hospital.svg') }}" alt="Ikon Hospital" width="45" height="45"
                class="rounded-circle me-3 bg-danger">
              <div>
                <h6 class="mb-0">Klinik Dokter Gigi</h6>
                <small>Gedung Cokro Aminoto Lt.4</small><br />
                <span class="badge bg-primary-subtle text-success mt-1">Surgical</span>
              </div>
            </div>
            <p class="mb-1">Senin - Jumat | 09:00 - 12 :00</p>
            <p>Kapasitas: 7/20</p>
            <a href="login.html">
              <button class="btn btn-danger text-white w-100">Book an appointment</button>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <!-- Doctor Card -->
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/hospital.svg') }}" alt="Ikon Hospital" width="45" height="45"
                class="rounded-circle me-3 bg-danger">
              <div>
                <h6 class="mb-0">Klinik Anak</h6>
                <small>Gedung Cokro Aminoto Lt.3</small><br>
                <span class="badge bg-danger-subtle text-danger mt-1">Pediatric</span>
              </div>
            </div>
            <p class="mb-1">Senin, Rabu | 10:00 - 13:00</p>
            <p>Kapasitas: 23/30</p>
            <a href="login.html">
              <button class="btn btn-danger text-white w-100">Book an appointment</button>
            </a>
          </div>
        </div>
      </div>

      <!-- Repeat cards -->
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/hospital.svg') }}" alt="Ikon Hospital" width="45" height="45"
                class="rounded-circle me-3 bg-danger">
              <div>
                <h6 class="mb-0">Klinik Bedah Mulut Maksilofasial</h6>
                <small>Gedung Cokro Aminoto Lt.3</small><br />
                <span class="badge bg-danger-subtle text-danger mt-1">Surgical</span>
              </div>
            </div>
            <p class="mb-1">Rabu, Jumat | 07:00 - 11:00</p>
            <p>Kapasitas: 2/15</p>
            <a href="login.html">
              <button class="btn btn-danger text-white w-100">Book an appointment</button>
            </a>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/hospital.svg') }}" alt="Ikon Hospital" width="45" height="45"
                class="rounded-circle me-3 bg-danger">
              <div>
                <h6 class="mb-0">Klinik Dokter Gigi</h6>
                <small>Gedung Cokro Aminoto Lt.4</small><br />
                <span class="badge bg-danger-subtle text-danger mt-1">Surgical</span>
              </div>
            </div>
            <p class="mb-1">Senin - Jumat | 09:00 - 12 :00</p>
            <p>Kapasitas: 7/20</p>
            <a href="login.html">
              <button class="btn btn-danger text-white w-100">Book an appointment</button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- WHY CHOOSE US -->
  <section class="container my-5" id="Layanan">
    <h4 class="text-center fw-bold text-danger mb-4">Kenapa Memilih AppointDoc?</h4>
    <div class="row text-center g-4">

      <!-- Keunggulan 1 -->
      <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100">
          <img src="https://cdn-icons-png.flaticon.com/512/869/869636.png" alt="Cepat & Mudah" width="60" class="mb-3">
          <h6 class="fw-semibold">Pendaftaran Cepat & Mudah</h6>
          <p class="text-muted small">Tanpa antre panjang, cukup daftar melalui sistem kami dari mana saja.</p>
        </div>
      </div>

      <!-- Keunggulan 2 -->
      <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100">
          <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" alt="Dokter Profesional" width="60"
            class="mb-3">
          <h6 class="fw-semibold">Dokter Profesional</h6>
          <p class="text-muted small">Ditangani oleh dokter berpengalaman dan kompeten di bidangnya.</p>
        </div>
      </div>

      <!-- Keunggulan 3 -->
      <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100">
          <img src="https://cdn-icons-png.flaticon.com/512/679/679922.png" alt="Pelayanan Ramah" width="60"
            class="mb-3">
          <h6 class="fw-semibold">Pelayanan Ramah</h6>
          <p class="text-muted small">Kami mengutamakan kenyamanan pasien dengan pelayanan yang bersahabat.</p>
        </div>
      </div>

    </div>
  </section>

  <!-- TESTIMONI -->
  <section class="container my-5" id="testimoni">
    <h4 class="mb-4 text-center fw-bold text-danger">
      Apa Kata Mereka Tentang AppointDoc?
    </h4>

    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        @foreach($testimonials->chunk(3) as $chunkIndex => $chunk)
        @include('partials.testimonial-slide', [
        'testimonials' => $chunk,
        'active' => $chunkIndex === 0,
        ])
    @endforeach
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bg-danger rounded-circle p-2" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
<button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-danger rounded-circle p-2" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
            </button>
    </div>

  <!-- FOOTER -->
  </section>
  <footer class="bg-danger text-white py-4">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5>Alamat</h5>
          <p>Jl. DI Panjaitan No.128, Karangreja, Purwokerto Kidul, Kec. Purwokerto Sel., Kabupaten Banyumas, Jawa
            Tengah 53147</p>
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.270756540308!2d109.24651767363716!3d-7.4352630925755525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e655ea49d9f9885%3A0x62be0b6159700ec9!2sTelkom%20Purwokerto%20University!5e0!3m2!1sid!2sid!4v1743670629696!5m2!1sid!2sid"
            width="350" height="250" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="col-md-4">
          <h5>Menu Utama</h5>
          <ul class="footer-fiture list-unstyled">
            <li><a href="#beranda" class="text-white">Beranda</a></li>
            <li><a href="#testimoni" class="text-white">Testimoni</a></li>
            <li><a href="#Layanan" class="text-white">Layanan</a></li>
          </ul>
        </div>
        <div class="contact-panel col-md-4">
          <div class="contact-list">
            <h5>Hubungi Kami</h5>
            <p>Kami Siap Melayani Anda Selama 24 Jam Dalam Situasi Darurat.</p>
            <div class="contlist d-flex">
              <ul class="colist list-unstyled mb-30">
                <li>
                  <i class="bi-telephone"></i>
                  <a href="tel:+6212345678"> +6212345678</a> (Instalasi Gawat Darurat)
                </li>
                <li>
                  <i class="bi-envelope-open"></i>
                  <a href="email:admin@siagasedia.com">admin@siagasedia.com</a>
                </li>
                <li>
                  <i class="bi-telephone"></i>
                  <a href="tel:+6212345678"> +6212345678</a> (Keluhan & Saran)
                </li>
                <li>
                  <i class="bi bi-clock"></i>
                  <a>Waktu Layanan: Senin - Sabtu: 08:00 am - 07.00 pm </a>
                </li>
              </ul>
            </div>



          </div>
        </div>

      </div>
      <hr>
      <div class="text-center">
        © 2025 AppointDoc. All rights reserved.
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>