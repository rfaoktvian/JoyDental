@extends('layouts.app')

@section('content')
<style>
    .gradient-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        overflow: hidden;
        position: relative;
    }
    
    .gradient-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.03)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    .stats-card {
        transition: all 0.3s ease;
        border: none;
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #d32f2f, #f44336);
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(211, 47, 47, 0.15);
    }
    
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #d32f2f, #f44336);
        color: white;
        box-shadow: 0 4px 15px rgba(211, 47, 47, 0.3);
    }
    
    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }
    
    .stats-label {
        color: #7f8c8d;
        font-size: 0.9rem;
        font-weight: 500;
        margin: 0;
    }
    
    .info-card {
        border: none;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
    
    .info-card-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-bottom: 1px solid #dee2e6;
        padding: 1.25rem 1.5rem;
        font-weight: 600;
        color: #495057;
    }
    
    .schedule-item {
        padding: 0.75rem 1.5rem;
        border-bottom: 1px solid #f8f9fa;
        display: flex;
        align-items: center;
        transition: background-color 0.2s ease;
    }
    
    .schedule-item:hover {
        background-color: #f8f9fa;
    }
    
    .schedule-item:last-child {
        border-bottom: none;
    }
    
    .schedule-day {
        font-weight: 600;
        color: #2c3e50;
        min-width: 80px;
    }
    
    .schedule-time {
        color: #7f8c8d;
        font-size: 0.9rem;
    }
    
    .consultation-detail {
        padding: 0.5rem 0;
        border-bottom: 1px solid #f8f9fa;
    }
    
    .consultation-detail:last-child {
        border-bottom: none;
    }
    
    .consultation-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.25rem;
    }
    
    .consultation-value {
        color: #6c757d;
        margin-bottom: 0;
    }
    
    .banner-enhanced {
        background: linear-gradient(135deg, #d32f2f, #b71c1c, #8d1e1e);
        background-size: 400% 400%;
        animation: gradientShift 8s ease infinite;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    
    .banner-enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="200" height="200" fill="url(%23dots)"/></svg>');
    }
    
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .welcome-text {
        z-index: 2;
        position: relative;
    }
    
    .dashboard-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 2rem;
        position: relative;
    }
    
    .dashboard-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #d32f2f, #f44336);
        border-radius: 2px;
    }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .floating-elements {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }
    
    .floating-elements::before,
    .floating-elements::after {
        content: '';
        position: absolute;
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    
    .floating-elements::before {
        top: 20%;
        right: 10%;
        animation-delay: -2s;
    }
    
    .floating-elements::after {
        bottom: 20%;
        right: 20%;
        animation-delay: -4s;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
</style>

<!-- Enhanced Banner dengan Greeting -->
<div class="banner-enhanced position-relative p-4 text-white d-flex align-items-center justify-content-between mb-5" style="height: 280px;">
    <div class="floating-elements"></div>
    <div class="welcome-text" style="z-index: 3; max-width: 60%;">
        <div class="mb-2">
            <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                <i class="fas fa-clock me-1"></i>{{ date('l, d F Y') }}
            </span>
        </div>
        <h1 class="display-5 fw-bold mb-3">
            Selamat Datang, Dr. {{ Auth::user()->name }}
        </h1>
        <p class="lead mb-3" style="font-size: 1.1rem; opacity: 0.95;">
            Kelola jadwal, antrian pasien, dan konsultasi dengan mudah.<br>
            Berikan pelayanan terbaik untuk pasien Anda.
        </p>
        <div class="d-flex align-items-center">
            <i class="fas fa-sun me-2" style="font-size: 1.5rem;"></i>
            <h4 class="mb-0 fw-semibold">Selamat bertugas hari ini!</h4>
        </div>
    </div>
    <div class="position-relative" style="z-index: 2;">
        <img src="{{ asset('images/doctors_dashboard.png') }}" alt="Doctors" 
             class="pulse-animation" 
             style="max-height: 240px; object-fit: contain; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));" />
    </div>
</div>

<div class="container-fluid">
    <h2 class="dashboard-title">Dashboard Dokter</h2>

    <!-- Enhanced Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-3">
            <div class="stats-card card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon me-4">
                            <i class="fas fa-user-injured fa-lg"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="stats-label mb-1">Pasien Hari Ini</p>
                            <h3 class="stats-number">12</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>+2 dari kemarin
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stats-card card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon me-4">
                            <i class="fas fa-clipboard-list fa-lg"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="stats-label mb-1">Antrian Aktif</p>
                            <h3 class="stats-number">5</h3>
                            <small class="text-warning">
                                <i class="fas fa-clock me-1"></i>Sedang berlangsung
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stats-card card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon me-4">
                            <i class="fas fa-file-medical fa-lg"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="stats-label mb-1">Rekam Medis</p>
                            <h3 class="stats-number">48</h3>
                            <small class="text-info">
                                <i class="far fa-file-alt me-1"></i>Data tersimpan
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stats-card card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon me-4">
                            <i class="fas fa-calendar-check fa-lg"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="stats-label mb-1">Jadwal Praktik</p>
                            <h3 class="stats-number" style="font-size: 1.5rem;">Sen-Jum</h3>
                            <small class="text-primary">
                                <i class="fas fa-clock me-1"></i>08:00 - 12:00
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Information Cards -->
    <div class="row g-4">
        <div class="col-lg-6 mb-4">
            <div class="info-card card h-100">
                <div class="info-card-header d-flex align-items-center">
                    <i class="fas fa-stethoscope text-danger me-2"></i>
                    <strong>Konsultasi Terakhir</strong>
                </div>
                <div class="card-body p-4">
                    <div class="consultation-detail">
                        <div class="consultation-label">
                            <i class="fas fa-user me-2 text-primary"></i>Nama Pasien
                        </div>
                        <p class="consultation-value">Andi Nugroho</p>
                    </div>
                    
                    <div class="consultation-detail">
                        <div class="consultation-label">
                            <i class="fas fa-diagnoses me-2 text-success"></i>Diagnosa
                        </div>
                        <p class="consultation-value">Hipertensi Ringan</p>
                    </div>
                    
                    <div class="consultation-detail">
                        <div class="consultation-label">
                            <i class="fas fa-procedures me-2 text-warning"></i>Tindakan
                        </div>
                        <p class="consultation-value">Pemeriksaan tekanan darah, edukasi gaya hidup sehat</p>
                    </div>
                    
                    <div class="consultation-detail">
                        <div class="consultation-label">
                            <i class="fas fa-calendar me-2 text-info"></i>Tanggal
                        </div>
                        <p class="consultation-value">27 Mei 2025</p>
                    </div>
                    
                    <div class="mt-3 pt-3 border-top">
                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#consultationDetailModal">
                            <i class="fas fa-eye me-1"></i>Lihat Detail
                        </button>
                        <button class="btn btn-outline-secondary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#printPrescriptionModal">
                            <i class="fas fa-print me-1"></i>Cetak Resep
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="info-card card h-100">
                <div class="info-card-header d-flex align-items-center">
                    <i class="fas fa-calendar-alt text-danger me-2"></i>
                    <strong>Jadwal Praktik Anda</strong>
                </div>
                <div class="card-body p-0">
                    <div class="schedule-item">
                        <div class="schedule-day">
                            <i class="far fa-calendar me-2 text-primary"></i>Senin
                        </div>
                        <div class="schedule-time flex-grow-1">08:00 - 12:00 WIB</div>
                        <span class="badge bg-success">Aktif</span>
                    </div>
                    
                    <div class="schedule-item">
                        <div class="schedule-day">
                            <i class="far fa-calendar me-2 text-primary"></i>Selasa
                        </div>
                        <div class="schedule-time flex-grow-1">08:00 - 12:00 WIB</div>
                        <span class="badge bg-success">Aktif</span>
                    </div>
                    
                    <div class="schedule-item">
                        <div class="schedule-day">
                            <i class="far fa-calendar me-2 text-primary"></i>Rabu
                        </div>
                        <div class="schedule-time flex-grow-1">08:00 - 12:00 WIB</div>
                        <span class="badge bg-success">Aktif</span>
                    </div>
                    
                    <div class="schedule-item">
                        <div class="schedule-day">
                            <i class="far fa-calendar me-2 text-primary"></i>Kamis
                        </div>
                        <div class="schedule-time flex-grow-1">08:00 - 12:00 WIB</div>
                        <span class="badge bg-success">Aktif</span>
                    </div>
                    
                    <div class="schedule-item">
                        <div class="schedule-day">
                            <i class="far fa-calendar me-2 text-primary"></i>Jumat
                        </div>
                        <div class="schedule-time flex-grow-1">08:00 - 11:00 WIB</div>
                        <span class="badge bg-warning">Pendek</span>
                    </div>
                </div>
                
                <div class="card-footer bg-light border-0">
                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#editScheduleModal">
                        <i class="fas fa-edit me-1"></i>Edit Jadwal
                    </button>
                    <button class="btn btn-outline-secondary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                        <i class="fas fa-calendar-plus me-1"></i>Tambah Jadwal
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="info-card card">
                <div class="info-card-header">
                    <i class="fas fa-bolt text-danger me-2"></i>
                    <strong>Aksi Cepat</strong>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary w-100 py-3" onclick="alert('Fitur Tambah Pasien')">
                                <i class="fas fa-plus-circle fa-2x mb-2"></i><br>
                                <span>Tambah Pasien</span>
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-success w-100 py-3" onclick="alert('Fitur Lihat Antrian')">
                                <i class="fas fa-list-ul fa-2x mb-2"></i><br>
                                <span>Lihat Antrian</span>
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-warning w-100 py-3" onclick="alert('Fitur Rekam Medis')">
                                <i class="fas fa-file-medical-alt fa-2x mb-2"></i><br>
                                <span>Rekam Medis</span>
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-danger w-100 py-3" onclick="alert('Fitur Laporan')">
                                <i class="fas fa-chart-line fa-2x mb-2"></i><br>
                                <span>Laporan</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Detail Konsultasi -->
<div class="modal fade" id="consultationDetailModal" tabindex="-1" aria-labelledby="consultationDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="consultationDetailModalLabel">
                    <i class="fas fa-stethoscope me-2"></i>Detail Konsultasi Terakhir
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Informasi Pasien</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold">Nama:</td>
                                <td>Andi Nugroho</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Umur:</td>
                                <td>45 Tahun</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Jenis Kelamin:</td>
                                <td>Laki-laki</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">No. Telepon:</td>
                                <td>+62 812-3456-7890</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-3"><i class="fas fa-clipboard-check me-2"></i>Detail Konsultasi</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold">Tanggal:</td>
                                <td>27 Mei 2025</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Waktu:</td>
                                <td>10:30 WIB</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Keluhan:</td>
                                <td>Pusing, mudah lelah</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Tekanan Darah:</td>
                                <td>150/90 mmHg</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <h6 class="text-warning"><i class="fas fa-diagnoses me-2"></i>Diagnosa</h6>
                    <p class="bg-light p-3 rounded">Hipertensi Ringan (Stadium 1)</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-info"><i class="fas fa-procedures me-2"></i>Tindakan yang Dilakukan</h6>
                    <ul class="list-unstyled bg-light p-3 rounded">
                        <li><i class="fas fa-check text-success me-2"></i>Pemeriksaan tekanan darah</li>
                        <li><i class="fas fa-check text-success me-2"></i>Edukasi gaya hidup sehat</li>
                        <li><i class="fas fa-check text-success me-2"></i>Pemberian resep obat antihipertensi</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-secondary"><i class="fas fa-notes-medical me-2"></i>Catatan Dokter</h6>
                    <p class="bg-light p-3 rounded">Pasien disarankan untuk mengurangi konsumsi garam, rutin berolahraga ringan, dan kontrol rutin setiap 2 minggu.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger">
                    <i class="fas fa-print me-1"></i>Cetak Laporan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Cetak Resep -->
<div class="modal fade" id="printPrescriptionModal" tabindex="-1" aria-labelledby="printPrescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="printPrescriptionModalLabel">
                    <i class="fas fa-print me-2"></i>Cetak Resep
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-prescription-bottle-alt fa-3x text-secondary mb-3"></i>
                    <h6>Resep untuk: <strong>Andi Nugroho</strong></h6>
                    <p class="text-muted">Tanggal: 27 Mei 2025</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="border-bottom pb-2">Obat yang Diresepkan:</h6>
                    <div class="bg-light p-3 rounded">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Amlodipine 5mg</span>
                            <span class="badge bg-primary">30 tablet</span>
                        </div>
                        <small class="text-muted">1x sehari, diminum setelah makan</small>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6 class="border-bottom pb-2">Instruksi Khusus:</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-exclamation-triangle text-warning me-2"></i>Hindari makanan tinggi garam</li>
                        <li><i class="fas fa-info-circle text-info me-2"></i>Minum obat pada waktu yang sama setiap hari</li>
                        <li><i class="fas fa-calendar-check text-success me-2"></i>Kontrol kembali dalam 2 minggu</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-print me-1"></i>Cetak Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Edit Jadwal -->
<div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="editScheduleModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Jadwal Praktik
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Hari</label>
                            <select class="form-select">
                                <option selected>Senin</option>
                                <option>Selasa</option>
                                <option>Rabu</option>
                                <option>Kamis</option>
                                <option>Jumat</option>
                                <option>Sabtu</option>
                                <option>Minggu</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jam Mulai</label>
                            <input type="time" class="form-control" value="08:00">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jam Selesai</label>
                            <input type="time" class="form-control" value="12:00">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h6 class="mb-3">Jadwal Saat Ini:</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="table-danger">
                                    <tr>
                                        <th>Hari</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Senin</td>
                                        <td>08:00</td>
                                        <td>12:00</td>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Selasa</td>
                                        <td>08:00</td>
                                        <td>12:00</td>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger">
                    <i class="fas fa-save me-1"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Jadwal -->
<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addScheduleModalLabel">
                    <i class="fas fa-calendar-plus me-2"></i>Tambah Jadwal Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Hari</label>
                        <select class="form-select" required>
                            <option value="">-- Pilih Hari --</option>
                            <option value="sabtu">Sabtu</option>
                            <option value="minggu">Minggu</option>
                        </select>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Jam Mulai</label>
                            <input type="time" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Jam Selesai</label>
                            <input type="time" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <label class="form-label fw-semibold">Kuota Pasien</label>
                        <input type="number" class="form-control" placeholder="Masukkan jumlah kuota" min="1" max="50">
                    </div>
                    
                    <div class="mt-3">
                        <label class="form-label fw-semibold">Catatan (Opsional)</label>
                        <textarea class="form-control" rows="3" placeholder="Catatan khusus untuk jadwal ini..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Tambah Jadwal
                </button>
            </div>
        </div>
    </div>
</div>
@endsection