@extends('layouts.app')

@section('content')
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

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="section-header">
                    <h2>Janji Temu Mendatang</h2>
                    <a href="tiket.html">Lihat Semua</a>
                </div>
                <div class="upcoming-appointment text-center py-4">
                    <img src="" alt="No appointments" class="mb-3">
                    <h3>Belum ada janji temu mendatang</h3>
                    <p class="text-muted">Jadwalkan konsultasi dengan dokter sekarang</p>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="section-header">
                    <h2>Dokter Rekomendasi</h2>
                    <a href="dokter.html">Lihat Semua</a>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="doctor-card">
                            <div class="doctor-header">
                                <div class="doctor-image">
                                    <img src="doctors_login.png" alt="Dr. Amanda">
                                </div>
                                <div class="doctor-info">
                                    <h3>Dr. Amanda Wijaya</h3>
                                    <div class="specialty">Spesialis | 12 tahun pengalaman</div>
                                    <span class="badge-specialty pediatric">Pediatric</span>
                                </div>
                            </div>
                            <div class="doctor-schedule">
                                <div class="schedule-info">
                                    <div><i class="far fa-calendar"></i> Sel, Kam</div>
                                    <div><i class="far fa-clock"></i> 09:00 - 14:00</div>
                                </div>
                                <div class="price">
                                    <div>Rp <span class="amount">225.000</span></div>
                                </div>
                            </div>
                            <a href="janji_temu.html">
                                <div class="p-3">
                                    <button class="btn-book w-100">Buat Janji Temu</button>
                                </div>
                            </a>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="doctor-card">
                            <div class="doctor-header">
                                <div class="doctor-image">
                                    <img src="doctors_login.png " alt="Dr. Jason">
                                </div>
                                <div class="doctor-info">
                                    <h3>Dr. Jason Santoso</h3>
                                    <div class="specialty">Spesialis | 10 tahun pengalaman</div>
                                    <span class="badge-specialty surgical">Surgical</span>
                                </div>
                            </div>
                            <div class="doctor-schedule">
                                <div class="schedule-info">
                                    <div><i class="far fa-calendar"></i> Sel, Kam</div>
                                    <div><i class="far fa-clock"></i> 10:00 - 15:00</div>
                                </div>
                                <div class="price">
                                    <div>Rp <span class="amount">235.000</span></div>
                                </div>
                            </div>
                            <a href="janji_temu.html">
                                <div class="p-3">
                                    <button class="btn-book w-100">Buat Janji Temu</button>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm overflow-hidden">
                @include('partials.calendar')
            </div>

            <div class="card shadow-sm">
                <div class="section-header">
                    <h2>Daftar Poliklinik</h2>
                    <a href="poliklinik.html">Lihat Semua</a>
                </div>
                <div class="polyclinic-list">
                    <div class="polyclinic-item d-flex align-items-center p-2 border-bottom">
                        <div class="flex-shrink-0">
                            <div
                                style="width: 40px; height: 40px; background-color: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-baby"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-0 fs-6">Klinik Anak</h4>
                            <div class="small text-muted">Gedung Cokro Aminoto Lt.3</div>
                        </div>
                        <div>
                            <span class="badge-specialty pediatric">Pediatric</span>
                        </div>
                    </div>
                    <div class="polyclinic-item d-flex align-items-center p-2 border-bottom">
                        <div class="flex-shrink-0">
                            <div
                                style="width: 40px; height: 40px; background-color: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-teeth"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-0 fs-6">Klinik Dokter Gigi</h4>
                            <div class="small text-muted">Gedung Cokro Aminoto Lt.4</div>
                        </div>
                        <div>
                            <span class="badge-specialty surgical">Surgical</span>
                        </div>
                    </div>
                    <div class="polyclinic-item d-flex align-items-center p-2">
                        <div class="flex-shrink-0">
                            <div
                                style="width: 40px; height: 40px; background-color: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-stethoscope"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-0 fs-6">Klinik Bedah Mulut</h4>
                            <div class="small text-muted">Gedung Cokro Aminoto Lt.3</div>
                        </div>
                        <div>
                            <span class="badge-specialty surgical">Surgical</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
@endsection
