@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
    {{-- Sidebar column (injected by layouts/app) --}}
    <div class="d-none d-lg-block col-lg-2 p-0">
      {{-- empty: sidebar lives here from layouts --}}
    </div>

    {{-- Main content --}}
    <div class="col-12 col-lg-10 px-4 py-3" id="content-wrapper">
      {{-- Banner --}}
      <div
      class="banner position-relative p-4 rounded text-white d-flex align-items-center justify-content-between overflow-hidden mb-5"
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

      {{-- Search Bar --}}
      <div
      class="search-bar bg-white shadow-sm rounded-pill p-2 d-flex align-items-center justify-content-between mx-auto mb-5"
      style="max-width: 600px; margin-top: -2rem;">
      <input type="text" class="form-control border-0 rounded-pill me-2" placeholder="Pencarian Poliklinik" />
      <button class="btn btn-danger text-white rounded-pill px-4">Cari</button>
      </div>

      {{-- Daftar Poliklinik --}}
      <section class="mb-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Daftar Poliklinik</h5>
        <a href="#" class="text-decoration-none text-danger">View All &gt;</a>
      </div>
      <div class="row g-4">
        <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
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
          <p class="mb-1">Senin, Rabu | 10:00 – 13:00</p>
          <p>Kapasitas: 23/30</p>
          <button class="btn btn-danger text-white w-100">Book an appointment</button>
          </div>
        </div>
        </div>

        <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <img src="{{ asset('images/hospital.svg') }}" alt="Ikon Hospital" width="45" height="45"
            class="rounded-circle me-3 bg-danger">
            <div>
            <h6 class="mb-0">Klinik Bedah Mulut Maksilofasial</h6>
            <small>Gedung Cokro Aminoto Lt.3</small><br>
            <span class="badge bg-info-subtle text-primary mt-1">Surgical</span>
            </div>
          </div>
          <p class="mb-1">Rabu, Jumat | 07:00 – 11:00</p>
          <p>Kapasitas: 2/15</p>
          <button class="btn btn-danger text-white w-100">Book an appointment</button>
          </div>
        </div>
        </div>

        <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <img src="{{ asset('images/hospital.svg') }}" alt="Ikon Hospital" width="45" height="45"
            class="rounded-circle me-3 bg-danger">
            <div>
            <h6 class="mb-0">Klinik Dokter Gigi</h6>
            <small>Gedung Cokro Aminoto Lt.4</small><br>
            <span class="badge bg-primary-subtle text-success mt-1">Surgical</span>
            </div>
          </div>
          <p class="mb-1">Senin – Jumat | 09:00 – 12:00</p>
          <p>Kapasitas: 7/20</p>
          <button class="btn btn-danger text-white w-100">Book an appointment</button>
          </div>
        </div>
        </div>
      </div>
      </section>

      {{-- Kenapa Memilih Kami --}}
      <section class="mb-5" id="Layanan">
      <h4 class="text-center fw-bold text-danger mb-4">Kenapa Memilih AppointDoc?</h4>
      <div class="row text-center g-4">
        <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100">
          <img src="https://cdn-icons-png.flaticon.com/512/869/869636.png" alt="Cepat & Mudah" width="60"
          class="mb-3">
          <h6 class="fw-semibold">Pendaftaran Cepat & Mudah</h6>
          <p class="text-muted small">
          Tanpa antre panjang, cukup daftar melalui sistem kami dari mana saja.
          </p>
        </div>
        </div>
        <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100">
          <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" alt="Dokter Profesional" width="60"
          class="mb-3">
          <h6 class="fw-semibold">Dokter Profesional</h6>
          <p class="text-muted small">
          Ditangani oleh dokter berpengalaman dan kompeten di bidangnya.
          </p>
        </div>
        </div>
        <div class="col-md-4">
        <div class="p-4 border rounded shadow-sm h-100">
          <img src="https://cdn-icons-png.flaticon.com/512/679/679922.png" alt="Pelayanan Ramah" width="60"
          class="mb-3">
          <h6 class="fw-semibold">Pelayanan Ramah</h6>
          <p class="text-muted small">
          Kami mengutamakan kenyamanan pasien dengan pelayanan yang bersahabat.
          </p>
        </div>
        </div>
      </div>
      </section>

      {{-- Testimoni Pasien --}}
      <section class="mb-5" id="testimoni">
      <h4 class="mb-4 text-center fw-bold text-danger">Apa Kata Mereka Tentang AppointDoc?</h4>
      <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="row g-4">
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/doctors_login.png') }}" class="rounded-circle me-3" alt="Rina"
                width="40" height="40">
              <div>
                <h6 class="mb-0 fw-semibold">Rina</h6>
                <small class="text-muted">34 tahun – Ibu Rumah Tangga</small>
              </div>
              </div>
              <hr>
              <p>"Pelayanannya cepat, dokter ramah, dan sistemnya sangat membantu!"</p>
            </div>
            </div>
          </div>
          {{-- repeat two more --}}
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/doctors_login.png') }}" class="rounded-circle me-3" alt="Budi"
                width="40" height="40">
              <div>
                <h6 class="mb-0 fw-semibold">Budi</h6>
                <small class="text-muted">40 tahun – Karyawan Swasta</small>
              </div>
              </div>
              <hr>
              <p>"Saya bisa booking dokter dari rumah tanpa antri lama. Sangat efisien!"</p>
            </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/doctors_login.png') }}" class="rounded-circle me-3" alt="Sari"
                width="40" height="40">
              <div>
                <h6 class="mb-0 fw-semibold">Sari</h6>
                <small class="text-muted">28 tahun – Freelancer</small>
              </div>
              </div>
              <hr>
              <p>"Platform ini membantu saya mendapatkan dokter yang tepat dengan cepat."</p>
            </div>
            </div>
          </div>
          </div>
        </div>
        {{-- second slide --}}
        <div class="carousel-item">
          <div class="row g-4">
          {{-- Dewi --}}
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/doctors_login.png') }}" class="rounded-circle me-3" alt="Dewi"
                width="40" height="40">
              <div>
                <h6 class="mb-0 fw-semibold">Dewi</h6>
                <small class="text-muted">25 tahun – Mahasiswa</small>
              </div>
              </div>
              <hr>
              <p>"Sangat terbantu dengan fitur antrian online, tidak perlu datang lebih awal."</p>
            </div>
            </div>
          </div>
          {{-- Andi --}}
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/doctors_login.png') }}" class="rounded-circle me-3" alt="Andi"
                width="40" height="40">
              <div>
                <h6 class="mb-0 fw-semibold">Andi</h6>
                <small class="text-muted">31 tahun – Pegawai Negeri</small>
              </div>
              </div>
              <hr>
              <p>"Saya suka desain aplikasinya, simpel dan mudah digunakan."</p>
            </div>
            </div>
          </div>
          {{-- Lina --}}
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/doctors_login.png') }}" class="rounded-circle me-3" alt="Lina"
                width="40" height="40">
              <div>
                <h6 class="mb-0 fw-semibold">Lina</h6>
                <small class="text-muted">38 tahun – Ibu 2 Anak</small>
              </div>
              </div>
              <hr>
              <p>"Dokternya profesional dan staffnya sangat membantu. Sangat recommended!"</p>
            </div>
            </div>
          </div>
          </div>
        </div><!-- /.carousel-item -->
        </div><!-- /.carousel-inner -->

        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-danger rounded-circle p-2"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
        data-bs-slide="next">
        <span class="carousel-control-next-icon bg-danger rounded-circle p-2"></span>
        <span class="visually-hidden">Next</span>
        </button>
      </div>
      </section>

      {{-- Testimoni Pasien --}}
      <section class="mb-5" id="testimoni">
      <h4 class="mb-4 text-center fw-bold text-danger">Apa Kata Mereka Tentang AppointDoc?</h4>
      <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="row g-4">
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/doctors_login.png') }}" class="rounded-circle me-3" alt="Rina"
                width="40" height="40">
              <div>
                <h6 class="mb-0 fw-semibold">Rina</h6>
                <small class="text-muted">34 tahun – Ibu Rumah Tangga</small>
              </div>
              </div>
              <hr>
              <p>"Pelayanannya cepat, dokter ramah, dan sistemnya sangat membantu!"</p>
            </div>
            </div>
          </div>
          {{-- repeat two more --}}
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/doctors_login.png') }}" class="rounded-circle me-3" alt="Budi"
                width="40" height="40">
              <div>
                <h6 class="mb-0 fw-semibold">Budi</h6>
                <small class="text-muted">40 tahun – Karyawan Swasta</small>
              </div>
              </div>
              <hr>
              <p>"Saya bisa booking dokter dari rumah tanpa antri lama. Sangat efisien!"</p>
            </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/doctors_login.png') }}" class="rounded-circle me-3" alt="Sari"
                width="40" height="40">
              <div>
                <h6 class="mb-0 fw-semibold">Sari</h6>
                <small class="text-muted">28 tahun – Freelancer</small>
              </div>
              </div>
              <hr>
              <p>"Platform ini membantu saya mendapatkan dokter yang tepat dengan cepat."</p>
            </div>
            </div>
          </div>
          </div>
        </div>
        {{-- second slide --}}
        <div class="carousel-item">
          <div class="row g-4">
          {{-- Dewi --}}
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/doctors_login.png') }}" class="rounded-circle me-3" alt="Dewi"
                width="40" height="40">
              <div>
                <h6 class="mb-0 fw-semibold">Dewi</h6>
                <small class="text-muted">25 tahun – Mahasiswa</small>
              </div>
              </div>
              <hr>
              <p>"Sangat terbantu dengan fitur antrian online, tidak perlu datang lebih awal."</p>
            </div>
            </div>
          </div>
          {{-- Andi --}}
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/doctors_login.png') }}" class="rounded-circle me-3" alt="Andi"
                width="40" height="40">
              <div>
                <h6 class="mb-0 fw-semibold">Andi</h6>
                <small class="text-muted">31 tahun – Pegawai Negeri</small>
              </div>
              </div>
              <hr>
              <p>"Saya suka desain aplikasinya, simpel dan mudah digunakan."</p>
            </div>
            </div>
          </div>
          {{-- Lina --}}
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('images/doctors_login.png') }}" class="rounded-circle me-3" alt="Lina"
                width="40" height="40">
              <div>
                <h6 class="mb-0 fw-semibold">Lina</h6>
                <small class="text-muted">38 tahun – Ibu 2 Anak</small>
              </div>
              </div>
              <hr>
              <p>"Dokternya profesional dan staffnya sangat membantu. Sangat recommended!"</p>
            </div>
            </div>
          </div>
          </div>
        </div><!-- /.carousel-item -->
        </div><!-- /.carousel-inner -->

        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-danger rounded-circle p-2"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
        data-bs-slide="next">
        <span class="carousel-control-next-icon bg-danger rounded-circle p-2"></span>
        <span class="visually-hidden">Next</span>
        </button>
      </div>
      </section>

    </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
@endsection