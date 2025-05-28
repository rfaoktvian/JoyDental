@extends('layouts.app')

@section('content')
  <!-- Main Content -->
  <div class="main-content">
    <div class="container-fluid">
    <!-- Tab dan Filter -->
    <div class="row mb-4">
      <div class="col-md-6">
      <ul class="nav ticket-tabs">
        <li class="nav-item">
        <a class="nav-link active" href="#">Semua</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">Akan Datang</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">Selesai</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">Dibatalkan</a>
        </li>
      </ul>
      </div>
      <div class="col-md-6">
      <div class="ticket-filter">
        <input type="text" class="form-control" placeholder="Cari tiket...">
        <select class="form-control">
        <option>Semua Poliklinik</option>
        <option>Klinik Anak</option>
        <option>Klinik Dokter Gigi</option>
        <option>Klinik Bedah Mulut</option>
        <option>Klinik Penyakit Dalam</option>
        <option>Klinik Mata</option>
        <option>Klinik Jantung</option>
        </select>
        <button class="btn"><i class="fas fa-search"></i></button>
      </div>
      </div>
    </div>

    <!-- Tiket Antrian Cards - Redesigned -->
    <div class="row">
      <!-- Tiket 1 -->
      <div class="col-md-6 col-lg-4">
      <div class="ticket-card">
        <!-- Header dengan Nomor Antrian -->
        <div class="ticket-header">
        <div>
          <div class="queue-label">Nomor Antrian</div>
          <div class="queue-number">A12</div>
        </div>
        <span class="ticket-status status-confirmed">Terkonfirmasi</span>
        </div>

        <div class="ticket-body">
        <!-- Info Klinik dan Kode Booking -->
        <div class="clinic-info">
          <div class="clinic-name">Klinik Anak (Pediatric)</div>
          <div class="booking-code-section">
          Kode Booking: <span class="booking-code">KP23051501</span>
          </div>
        </div>

        <!-- Informasi Detail -->
        <dl class="row ticket-info">
          <dt class="col-sm-4">Dokter</dt>
          <dd class="col-sm-8">Dr. Amanda Wijaya</dd>

          <dt class="col-sm-4">Jadwal</dt>
          <dd class="col-sm-8">Selasa, 13 Mei 2025<br>09:00 - 14:00 WIB</dd>

          <dt class="col-sm-4">Pasien</dt>
          <dd class="col-sm-8">Walidddd</dd>
        </dl>

        <!-- QR Code di bawah info -->
        <div class="qr-section">
          <div class="qr-code">
          <i class="fas fa-qrcode fa-3x"></i>
          </div>
          <div class="qr-info">
          <p class="mb-0">Tunjukkan QR code ini saat check-in di rumah sakit</p>
          <small>Dibuat: 10 Mei 2025, 14:30</small>
          </div>
        </div>
        </div>

        <!-- Footer dengan Action Buttons -->
        <div class="ticket-footer">
        <div class="ticket-actions">
          <button class="btn btn-action btn-print">
          <i class="fas fa-print"></i> Cetak
          </button>
          <button class="btn btn-action btn-reschedule">
          <i class="fas fa-calendar-alt"></i> Jadwal Ulang
          </button>
          <button class="btn btn-action btn-cancel" data-bs-toggle="modal" data-bs-target="#cancelModal1">
          <i class="fas fa-times-circle"></i> Batalkan
          </button>
        </div>
        </div>
      </div>
      </div>

      <!-- Tiket 2 -->
      <div class="col-md-6 col-lg-4">
      <div class="ticket-card">
        <div class="ticket-header">
        <div>
          <div class="queue-label">Nomor Antrian</div>
          <div class="queue-number">B05</div>
        </div>
        <span class="ticket-status status-waiting">Menunggu</span>
        </div>

        <div class="ticket-body">
        <div class="clinic-info">
          <div class="clinic-name">Klinik Dokter Gigi (Surgical)</div>
          <div class="booking-code-section">
          Kode Booking: <span class="booking-code">KG23050902</span>
          </div>
        </div>

        <dl class="row ticket-info">
          <dt class="col-sm-4">Dokter</dt>
          <dd class="col-sm-8">Dr. Jason Santoso</dd>

          <dt class="col-sm-4">Jadwal</dt>
          <dd class="col-sm-8">Kamis, 15 Mei 2025<br>10:00 - 12:00 WIB</dd>

          <dt class="col-sm-4">Pasien</dt>
          <dd class="col-sm-8">Walidddd</dd>
        </dl>

        <div class="qr-section">
          <div class="qr-code">
          <i class="fas fa-qrcode fa-3x"></i>
          </div>
          <div class="qr-info">
          <p class="mb-0">Tunjukkan QR code ini saat check-in di rumah sakit</p>
          <small>Dibuat: 12 Mei 2025, 09:15</small>
          </div>
        </div>
        </div>

        <div class="ticket-footer">
        <div class="ticket-actions">
          <button class="btn btn-action btn-print">
          <i class="fas fa-print"></i> Cetak
          </button>
          <button class="btn btn-action btn-reschedule">
          <i class="fas fa-calendar-alt"></i> Jadwal Ulang
          </button>
          <button class="btn btn-action btn-cancel" data-bs-toggle="modal" data-bs-target="#cancelModal2">
          <i class="fas fa-times-circle"></i> Batalkan
          </button>
        </div>
        </div>
      </div>
      </div>

      <!-- Tiket 3 -->
      <div class="col-md-6 col-lg-4">
      <div class="ticket-card">
        <div class="ticket-header">
        <div>
          <div class="queue-label">Nomor Antrian</div>
          <div class="queue-number">C08</div>
        </div>
        <span class="ticket-status status-completed">Selesai</span>
        </div>

        <div class="ticket-body">
        <div class="clinic-info">
          <div class="clinic-name">Klinik Penyakit Dalam</div>
          <div class="booking-code-section">
          Kode Booking: <span class="booking-code">KP23050103</span>
          </div>
        </div>

        <dl class="row ticket-info">
          <dt class="col-sm-4">Dokter</dt>
          <dd class="col-sm-8">Dr. Budi Santoso</dd>

          <dt class="col-sm-4">Jadwal</dt>
          <dd class="col-sm-8">Jumat, 02 Mei 2025<br>13:00 - 15:00 WIB</dd>

          <dt class="col-sm-4">Pasien</dt>
          <dd class="col-sm-8">Walidddd</dd>
        </dl>

        <div class="qr-section">
          <div class="qr-code opacity-50">
          <i class="fas fa-qrcode fa-3x"></i>
          </div>
          <div class="qr-info">
          <p class="mb-0">Kunjungan Selesai</p>
          <small>Dibuat: 01 Mei 2025, 10:45</small>
          </div>
        </div>
        </div>

        <div class="ticket-footer">
        <div class="ticket-actions">
          <button class="btn btn-action btn-print">
          <i class="fas fa-print"></i> Cetak
          </button>
          <button class="btn btn-action btn-view">
          <i class="fas fa-file-medical"></i> Lihat Hasil
          </button>
        </div>
        </div>
      </div>
      </div>

      <!-- Tiket 4 -->
      <div class="col-md-6 col-lg-4">
      <div class="ticket-card">
        <div class="ticket-header">
        <div>
          <div class="queue-label">Nomor Antrian</div>
          <div class="queue-number">D03</div>
        </div>
        <span class="ticket-status status-confirmed">Terkonfirmasi</span>
        </div>

        <div class="ticket-body">
        <div class="clinic-info">
          <div class="clinic-name">Klinik Mata (Ophthalmology)</div>
          <div class="booking-code-section">
          Kode Booking: <span class="booking-code">KM23051504</span>
          </div>
        </div>

        <dl class="row ticket-info">
          <dt class="col-sm-4">Dokter</dt>
          <dd class="col-sm-8">Dr. Ratna Indah</dd>

          <dt class="col-sm-4">
          <dt class="col-sm-4">Jadwal</dt>
          <dd class="col-sm-8">Senin, 19 Mei 2025<br>08:00 - 10:00 WIB</dd>

          <dt class="col-sm-4">Pasien</dt>
          <dd class="col-sm-8">Walidddd</dd>
        </dl>

        <div class="qr-section">
          <div class="qr-code">
          <i class="fas fa-qrcode fa-3x"></i>
          </div>
          <div class="qr-info">
          <p class="mb-0">Tunjukkan QR code ini saat check-in di rumah sakit</p>
          <small>Dibuat: 14 Mei 2025, 16:20</small>
          </div>
        </div>
        </div>

        <div class="ticket-footer">
        <div class="ticket-actions">
          <button class="btn btn-action btn-print">
          <i class="fas fa-print"></i> Cetak
          </button>
          <button class="btn btn-action btn-reschedule">
          <i class="fas fa-calendar-alt"></i> Jadwal Ulang
          </button>
          <button class="btn btn-action btn-cancel" data-bs-toggle="modal" data-bs-target="#cancelModal4">
          <i class="fas fa-times-circle"></i> Batalkan
          </button>
        </div>
        </div>
      </div>
      </div>

      <!-- Tiket 5 -->
      <div class="col-md-6 col-lg-4">
      <div class="ticket-card">
        <div class="ticket-header">
        <div>
          <div class="queue-label">Nomor Antrian</div>
          <div class="queue-number">E15</div>
        </div>
        <span class="ticket-status status-cancelled">Dibatalkan</span>
        </div>

        <div class="ticket-body">
        <div class="clinic-info">
          <div class="clinic-name">Klinik Jantung (Cardiology)</div>
          <div class="booking-code-section">
          Kode Booking: <span class="booking-code">KJ23042905</span>
          </div>
        </div>

        <dl class="row ticket-info">
          <dt class="col-sm-4">Dokter</dt>
          <dd class="col-sm-8">Dr. Hendro Wijaya</dd>

          <dt class="col-sm-4">Jadwal</dt>
          <dd class="col-sm-8">Rabu, 30 April 2025<br>14:00 - 16:00 WIB</dd>

          <dt class="col-sm-4">Pasien</dt>
          <dd class="col-sm-8">Walidddd</dd>
        </dl>

        <div class="qr-section">
          <div class="qr-code opacity-50">
          <i class="fas fa-qrcode fa-3x"></i>
          </div>
          <div class="qr-info">
          <p class="mb-0">Dibatalkan oleh pasien</p>
          <small>Dibuat: 29 April 2025, 11:35</small>
          </div>
        </div>
        </div>

        <div class="ticket-footer">
        <div class="ticket-actions">
          <button class="btn btn-action btn-print">
          <i class="fas fa-print"></i> Cetak
          </button>
          <button class="btn btn-action btn-reschedule">
          <i class="fas fa-calendar-alt"></i> Jadwal Baru
          </button>
        </div>
        </div>
      </div>
      </div>

      <!-- Tiket 6 -->
      <div class="col-md-6 col-lg-4">
      <div class="ticket-card">
        <div class="ticket-header">
        <div>
          <div class="queue-label">Nomor Antrian</div>
          <div class="queue-number">F09</div>
        </div>
        <span class="ticket-status status-waiting">Menunggu</span>
        </div>

        <div class="ticket-body">
        <div class="clinic-info">
          <div class="clinic-name">Klinik Bedah Mulut</div>
          <div class="booking-code-section">
          Kode Booking: <span class="booking-code">KB23052006</span>
          </div>
        </div>

        <dl class="row ticket-info">
          <dt class="col-sm-4">Dokter</dt>
          <dd class="col-sm-8">Dr. Irfan Pratama</dd>

          <dt class="col-sm-4">Jadwal</dt>
          <dd class="col-sm-8">Rabu, 21 Mei 2025<br>09:30 - 11:30 WIB</dd>

          <dt class="col-sm-4">Pasien</dt>
          <dd class="col-sm-8">Walidddd</dd>
        </dl>

        <div class="qr-section">
          <div class="qr-code">
          <i class="fas fa-qrcode fa-3x"></i>
          </div>
          <div class="qr-info">
          <p class="mb-0">Tunjukkan QR code ini saat check-in di rumah sakit</p>
          <small>Dibuat: 15 Mei 2025, 08:40</small>
          </div>
        </div>
        </div>

        <div class="ticket-footer">
        <div class="ticket-actions">
          <button class="btn btn-action btn-print">
          <i class="fas fa-print"></i> Cetak
          </button>
          <button class="btn btn-action btn-reschedule">
          <i class="fas fa-calendar-alt"></i> Jadwal Ulang
          </button>
          <button class="btn btn-action btn-cancel" data-bs-toggle="modal" data-bs-target="#cancelModal6">
          <i class="fas fa-times-circle"></i> Batalkan
          </button>
        </div>
        </div>
      </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
      <div class="col-12">
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
          <i class="fas fa-chevron-left"></i>
          </a>
        </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#">
          <i class="fas fa-chevron-right"></i>
          </a>
        </li>
        </ul>
      </nav>
      </div>
    </div>
    </div>
  </div>

  <!-- Modal untuk Konfirmasi Pembatalan Tiket 1 -->
  <div class="modal fade modal-confirm" id="cancelModal1" tabindex="-1" aria-labelledby="cancelModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="cancelModalLabel1">Konfirmasi Pembatalan</h5>
      </div>
      <div class="modal-body">
      <div class="icon-box">
        <i class="fas fa-times-circle"></i>
      </div>
      <h4 class="modal-title mt-3">Apakah Anda yakin?</h4>
      <p class="mb-0 mt-3">Anda akan membatalkan janji temu dengan Dr. Amanda Wijaya pada Selasa, 13 Mei 2025.</p>
      <p class="text-muted small mt-2">Pembatalan kurang dari 24 jam sebelum jadwal dapat dikenakan biaya
        administrasi.</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
      <button type="button" class="btn btn-danger">Ya, Batalkan</button>
      </div>
    </div>
    </div>
  </div>

  <!-- Modal untuk Konfirmasi Pembatalan Tiket 2 -->
  <div class="modal fade modal-confirm" id="cancelModal2" tabindex="-1" aria-labelledby="cancelModalLabel2"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="cancelModalLabel2">Konfirmasi Pembatalan</h5>
      </div>
      <div class="modal-body">
      <div class="icon-box">
        <i class="fas fa-times-circle"></i>
      </div>
      <h4 class="modal-title mt-3">Apakah Anda yakin?</h4>
      <p class="mb-0 mt-3">Anda akan membatalkan janji temu dengan Dr. Jason Santoso pada Kamis, 15 Mei 2025.</p>
      <p class="text-muted small mt-2">Pembatalan kurang dari 24 jam sebelum jadwal dapat dikenakan biaya
        administrasi.</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
      <button type="button" class="btn btn-danger">Ya, Batalkan</button>
      </div>
    </div>
    </div>
  </div>

  <!-- Modal untuk Konfirmasi Pembatalan Tiket 4 -->
  <div class="modal fade modal-confirm" id="cancelModal4" tabindex="-1" aria-labelledby="cancelModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="cancelModalLabel4">Konfirmasi Pembatalan</h5>
      </div>
      <div class="modal-body">
      <div class="icon-box">
        <i class="fas fa-times-circle"></i>
      </div>
      <h4 class="modal-title mt-3">Apakah Anda yakin?</h4>
      <p class="mb-0 mt-3">Anda akan membatalkan janji temu dengan Dr. Ratna Indah pada Senin, 19 Mei 2025.</p>
      <p class="text-muted small mt-2">Pembatalan kurang dari 24 jam sebelum jadwal dapat dikenakan biaya
        administrasi.</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
      <button type="button" class="btn btn-danger">Ya, Batalkan</button>
      </div>
    </div>
    </div>
  </div>

  <!-- Modal untuk Konfirmasi Pembatalan Tiket 6 -->
  <div class="modal fade modal-confirm" id="cancelModal6" tabindex="-1" aria-labelledby="cancelModalLabel6"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="cancelModalLabel6">Konfirmasi Pembatalan</h5>
      </div>
      <div class="modal-body">
      <div class="icon-box">
        <i class="fas fa-times-circle"></i>
      </div>
      <h4 class="modal-title mt-3">Apakah Anda yakin?</h4>
      <p class="mb-0 mt-3">Anda akan membatalkan janji temu dengan Dr. Irfan Pratama pada Rabu, 21 Mei 2025.</p>
      <p class="text-muted small mt-2">Pembatalan kurang dari 24 jam sebelum jadwal dapat dikenakan biaya
        administrasi.</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
      <button type="button" class="btn btn-danger">Ya, Batalkan</button>
      </div>
    </div>
    </div>
  </div>

  <!-- Modal untuk Cetak Tiket -->
  <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-white">
      <h5 class="modal-title" id="printModalLabel">Cetak Tiket Antrian</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="print-preview p-3">
        <!-- Preview Tiket yang akan dicetak -->
        <div class="ticket-print-preview p-4 border rounded mb-4">
        <div class="text-center mb-3">
          <h3 class="mb-1">AppointDoc</h3>
          <p class="text-muted mb-0">Jl. Kesehatan No. 123, Jakarta</p>
          <p class="text-muted">Telp: (021) 1234-5678</p>
        </div>

        <div class="row mb-3">
          <div class="col-12 text-center">
          <h4 class="border-bottom border-top py-2 mb-3">TIKET ANTRIAN</h4>
          <div class="queue-number-print" style="font-size: 48px; font-weight: 800;">A12</div>
          <p class="text-muted">Kode Booking: <strong>KP23051501</strong></p>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
          <table class="table table-bordered">
            <tbody>
            <tr>
              <th style="width: 35%">Poliklinik</th>
              <td>Klinik Anak (Pediatric)</td>
            </tr>
            <tr>
              <th>Dokter</th>
              <td>Dr. Amanda Wijaya</td>
            </tr>
            <tr>
              <th>Jadwal</th>
              <td>Selasa, 13 Mei 2025<br>09:00 - 14:00 WIB</td>
            </tr>
            <tr>
              <th>Nama Pasien</th>
              <td>Walidddd</td>
            </tr>
            <tr>
              <th>Status</th>
              <td><span class="badge bg-success">Terkonfirmasi</span></td>
            </tr>
            </tbody>
          </table>
          </div>
        </div>

        <div class="row justify-content-between align-items-center mt-3">
          <div class="col-6">
          <div class="qr-code-print border p-2 text-center" style="width: 100px; height: 100px;">
            <i class="fas fa-qrcode fa-4x"></i>
          </div>
          </div>
          <div class="col-6 text-end">
          <p class="small text-muted mb-0">Tanggal Cetak: 15 Mei 2025</p>
          <p class="small text-muted">Dibuat: 10 Mei 2025, 14:30</p>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-12">
          <div class="alert alert-warning small">
            <i class="fas fa-info-circle me-2"></i>
            Mohon hadir 30 menit sebelum jadwal untuk proses registrasi. Tunjukkan tiket ini atau QR code saat
            check-in di rumah sakit.
          </div>
          </div>
        </div>
        </div>

        <!-- Print Settings -->
        <div class="print-settings">
        <h5>Pengaturan Cetak</h5>
        <div class="row g-3">
          <div class="col-md-6">
          <label class="form-label">Ukuran Kertas</label>
          <select class="form-select">
            <option selected>A4</option>
            <option>A5</option>
            <option>Letter</option>
          </select>
          </div>
          <div class="col-md-6">
          <label class="form-label">Jumlah Salinan</label>
          <input type="number" class="form-control" value="1" min="1" max="10">
          </div>
        </div>
        </div>
      </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      <button type="button" class="btn btn-primary" onclick="printTicket()">
        <i class="fas fa-print me-1"></i> Cetak Sekarang
      </button>
      </div>
    </div>
    </div>
  </div>

  <!-- Modal untuk Jadwal Ulang -->
  <div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
      <h5 class="modal-title" id="rescheduleModalLabel">Jadwal Ulang Janji Temu</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="current-appointment p-3 mb-3 bg-light rounded">
        <h6 class="mb-2">Detail Janji Temu Saat Ini:</h6>
        <div class="row g-2">
        <div class="col-4 text-muted">Poliklinik:</div>
        <div class="col-8">Klinik Anak (Pediatric)</div>

        <div class="col-4 text-muted">Dokter:</div>
        <div class="col-8">Dr. Amanda Wijaya</div>

        <div class="col-4 text-muted">Jadwal:</div>
        <div class="col-8">Selasa, 13 Mei 2025<br>09:00 - 14:00 WIB</div>

        <div class="col-4 text-muted">Kode Booking:</div>
        <div class="col-8 fw-bold">KP23051501</div>
        </div>
      </div>

      <form>
        <h6 class="mb-3">Pilih Jadwal Baru:</h6>

        <div class="mb-3">
        <label class="form-label">Dokter</label>
        <select class="form-select">
          <option selected>Dr. Amanda Wijaya</option>
          <option>Dr. Budi Pratama</option>
          <option>Dr. Cindy Wijaya</option>
          <option>Dr. Dian Kusuma</option>
        </select>
        </div>

        <div class="mb-3">
        <label class="form-label">Tanggal</label>
        <input type="date" class="form-control" min="2025-05-16">
        </div>

        <div class="mb-3">
        <label class="form-label">Sesi Waktu Tersedia</label>
        <div class="time-slots">
          <div class="row g-2">
          <div class="col-md-4">
            <div class="form-check time-slot-card p-2 border rounded text-center">
            <input class="form-check-input" type="radio" name="timeSlot" id="slot1" checked>
            <label class="form-check-label w-100" for="slot1">
              <div class="time-value">09:00</div>
              <small class="text-muted">Pagi</small>
            </label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-check time-slot-card p-2 border rounded text-center">
            <input class="form-check-input" type="radio" name="timeSlot" id="slot2">
            <label class="form-check-label w-100" for="slot2">
              <div class="time-value">10:00</div>
              <small class="text-muted">Pagi</small>
            </label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-check time-slot-card p-2 border rounded text-center">
            <input class="form-check-input" type="radio" name="timeSlot" id="slot3">
            <label class="form-check-label w-100" for="slot3">
              <div class="time-value">11:00</div>
              <small class="text-muted">Pagi</small>
            </label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-check time-slot-card p-2 border rounded text-center">
            <input class="form-check-input" type="radio" name="timeSlot" id="slot4">
            <label class="form-check-label w-100" for="slot4">
              <div class="time-value">13:00</div>
              <small class="text-muted">Siang</small>
            </label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-check time-slot-card p-2 border rounded text-center">
            <input class="form-check-input" type="radio" name="timeSlot" id="slot5">
            <label class="form-check-label w-100" for="slot5">
              <div class="time-value">14:00</div>
              <small class="text-muted">Siang</small>
            </label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-check time-slot-card p-2 border rounded text-center">
            <input class="form-check-input" type="radio" name="timeSlot" id="slot6">
            <label class="form-check-label w-100" for="slot6">
              <div class="time-value">15:00</div>
              <small class="text-muted">Siang</small>
            </label>
            </div>
          </div>
          </div>
        </div>
        </div>

        <div class="mb-3">
        <label class="form-label">Alasan Penjadwalan Ulang <span class="text-muted">(Opsional)</span></label>
        <select class="form-select">
          <option selected>Pilih alasan</option>
          <option>Jadwal bertabrakan</option>
          <option>Perubahan kondisi</option>
          <option>Tidak bisa hadir</option>
          <option>Lainnya</option>
        </select>
        </div>

        <div class="mb-3">
        <label class="form-label">Catatan <span class="text-muted">(Opsional)</span></label>
        <textarea class="form-control" rows="2" placeholder="Tambahkan catatan..."></textarea>
        </div>
      </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      <button type="button" class="btn btn-info text-white">Konfirmasi Jadwal Ulang</button>
      </div>
    </div>
    </div>
  </div>
  <!-- Modal untuk Konfirmasi Keluar -->
  <div class="modal fade modal-confirm" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Keluar</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="icon-box">
        <i class="fas fa-sign-out-alt text-warning"></i>
      </div>
      <h4 class="modal-title mt-3">Keluar dari AppointDoc?</h4>
      <p class="mb-0 mt-3">Apakah Anda yakin ingin keluar dari sistem?</p>
      <p class="text-muted small mt-2">Semua perubahan yang belum disimpan akan hilang.</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      <a href="dashboard.html" class="btn btn-danger">Ya, Keluar</a>
      </div>
    </div>
    </div>
  </div>
  <!-- Bootstrap & Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

  <!-- JavaScript untuk toggle sidebar -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const body = document.body;

    // Event listener untuk menu keluar
    const logoutLink = document.querySelector('.sidebar .nav-item:last-child .nav-link');
    if (logoutLink) {
      logoutLink.addEventListener('click', function (e) {
      e.preventDefault(); // Mencegah link langsung diikuti
      const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
      logoutModal.show();
      });
    }

    // Fungsi toggle yang diperbarui
    sidebarToggle.addEventListener('click', function () {
      body.classList.toggle('sidebar-collapsed');
    });
    });

    function removeUnwantedIframes() {
    // Mencari semua iframe dengan URL yang berisi "remove.video"
    const iframes = document.querySelectorAll('iframe[src*="remove.video"]');

    // Menghapus iframe dan parent div-nya jika ditemukan
    iframes.forEach(iframe => {
      const parentDiv = iframe.parentElement;
      if (parentDiv && parentDiv.tagName === 'DIV') {
      console.log('Menghapus iframe yang tidak diinginkan:', iframe.src);
      parentDiv.remove();
      }
    });
    }

    // Jalankan segera setelah DOM dimuat
    document.addEventListener('DOMContentLoaded', removeUnwantedIframes);

    // Jalankan lagi setelah beberapa detik untuk menangani injeksi yang tertunda
    setTimeout(removeUnwantedIframes, 1000);
    setTimeout(removeUnwantedIframes, 3000);

    // Tambahkan MutationObserver untuk mendeteksi perubahan DOM
    const observer = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
      if (mutation.addedNodes.length) {
      removeUnwantedIframes();
      }
    });
    });

    // Mulai mengamati perubahan pada dokumen
    observer.observe(document.documentElement, {
    childList: true,
    subtree: true
    });

    // Tooltips Initialization
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Event listeners untuk tombol cetak
    document.querySelectorAll('.btn-print').forEach(button => {
    button.addEventListener('click', function () {
      var modal = new bootstrap.Modal(document.getElementById('printModal'));
      modal.show();
    });
    });

    // Event listeners untuk tombol jadwal ulang
    document.querySelectorAll('.btn-reschedule').forEach(button => {
    button.addEventListener('click', function () {
      var modal = new bootstrap.Modal(document.getElementById('rescheduleModal'));
      modal.show();
    });
    });

    // Fungsi untuk mencetak tiket
    function printTicket() {
    // Buat elemen mencetak
    var printContents = document.querySelector('.ticket-print-preview').innerHTML;
    var originalContents = document.body.innerHTML;

    // Ganti konten body dengan preview tiket
    document.body.innerHTML = `
          <div class="print-only" style="padding: 20px;">
            ${printContents}
          </div>
          <style>
            @media print {
              body { margin: 0; padding: 20px; }
              .print-only { max-width: 800px; margin: 0 auto; }
            }
          </style>
        `;

    // Panggil dialog print browser
    window.print();

    // Kembalikan konten asli
    document.body.innerHTML = originalContents;

    // Reinisialisasi event listeners setelah body kembali
    setTimeout(function () {
      // Reinit tooltips
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
      });

      // Reinit sidebar toggle
      document.getElementById('sidebarToggle').addEventListener('click', function () {
      document.body.classList.toggle('sidebar-collapsed');
      });

      // Reinit print buttons
      document.querySelectorAll('.btn-print').forEach(button => {
      button.addEventListener('click', function () {
        var modal = new bootstrap.Modal(document.getElementById('printModal'));
        modal.show();
      });
      });

      // Reinit reschedule buttons
      document.querySelectorAll('.btn-reschedule').forEach(button => {
      button.addEventListener('click', function () {
        var modal = new bootstrap.Modal(document.getElementById('rescheduleModal'));
        modal.show();
      });
      });
    }, 1000);
    }
  </script>
@endsection