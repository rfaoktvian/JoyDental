@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <form id="appointmentForm" action="" method="POST" class="needs-validation" novalidate>
            @csrf

            <div class="mb-4 border-bottom pb-2">
                <h2 class="fw-bold mb-1">Janji Temu Online!</h2>
                <p class="fw-light text-muted mb-0">
                    Janji temu adalah proses penjadwalan pertemuan antara pasien dan dokter
                    di fasilitas kesehatan untuk mendapatkan layanan medis sesuai kebutuhan.
                </p>
            </div>

            <div class="card h-100 shadow-sm bg-white border border-1 border-mute mb-4">
                <div class="card-header bg-danger text-white fw-semibold">
                    <i class="fas fa-hospital me-2"></i> Pilih Poliklinik
                </div>
                <div class="card-body">
                    <label for="polyclinic" class="form-label">Daftar Poliklinik <span class="text-danger">*</span></label>
                    <select class="form-select @error('polyclinic') is-invalid @enderror" id="polyclinic" name="polyclinic"
                        required>
                        <option value="" disabled selected>Pilih Poliklinik</option>
                    </select>
                    <div class="form-text">Pilih poliklinik yang akan Anda kunjungi</div>
                    @error('polyclinic')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card h-100 shadow-sm bg-white border border-1 border-mute mb-4">
                <div class="card-header bg-danger text-white fw-semibold">
                    <i class="fas fa-user-md me-2"></i> Pilih Dokter & Jadwal
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="doctor" class="form-label fw-semibold">Dokter yang Tersedia <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('doctor') is-invalid @enderror" id="doctor" name="doctor"
                                required>
                                <option value="" disabled selected>Pilih Dokter</option>
                            </select>
                            @error('doctor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="visit_date" class="form-label fw-semibold">Tanggal Kunjungan <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('visit_date') is-invalid @enderror"
                                id="visit_date" name="visit_date" min="{{ date('Y-m-d') }}" value="{{ old('visit_date') }}"
                                required>
                            @error('visit_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div id="doctor-info" class="card bg-light mt-4 border-0 d-none">
                        <div class="card-body">
                            <h6 class="text-danger">Informasi Dokter:</h6>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Spesialisasi:</strong> <span id="doctor-specialty">–</span>
                                    </p>
                                    <p class="mb-1"><strong>Pengalaman:</strong> <span id="doctor-experience">–</span>
                                        tahun</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Jadwal:</strong> <span id="doctor-schedule">–</span></p>
                                    <p class="mb-0"><strong>Jam:</strong> <span id="doctor-time">–</span></p>
                                </div>
                            </div>
                            <p class="mt-2 text-success"><strong>Biaya:</strong> Rp <span id="doctor-price">–</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card h-100 shadow-sm bg-white border border-1 border-mute mb-4">
                <div class="card-header bg-danger text-white fw-semibold">
                    <i class="fas fa-user me-2"></i> Identitas Pasien
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="otherPatientSwitch">
                        <label class="form-check-label" for="otherPatientSwitch">Pasien Lain</label>
                    </div>
                    <div id="selfPatient">
                    </div>
                    <div id="otherPatient" class="d-none">
                    </div>

                    <label class="form-label fw-semibold mt-4">Keluhan <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('complaint') is-invalid @enderror" name="complaint" rows="4" required>{{ old('complaint') }}</textarea>
                    @error('complaint')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card h-100 shadow-sm bg-white border border-1 border-mute mb-4">
                <div class="card-header bg-danger text-white fw-semibold">
                    <i class="fas fa-credit-card me-2"></i> Cara Bayar
                </div>
                <div class="card-body">
                    <label for="payment_method" class="form-label">Metode Pembayaran <span
                            class="text-danger">*</span></label>
                    <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method"
                        name="payment_method" required>
                        <option value="" disabled selected>Pilih Metode Pembayaran</option>
                    </select>
                    @error('payment_method')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Pasien harap datang 15 menit sebelum jadwal, kehadiran melebihi 30 menit akan dibatalkan otomatis.
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-danger mb-4 shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <i class="fas fa-clipboard-list me-2"></i> Ringkasan Pemesanan
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-6">Poliklinik:</dt>
                                <dd class="col-6" id="summary-polyclinic">–</dd>
                                <dt class="col-6">Dokter:</dt>
                                <dd class="col-6" id="summary-doctor">–</dd>
                                <dt class="col-6">Jadwal:</dt>
                                <dd class="col-6" id="summary-schedule">–</dd>
                                <dt class="col-6">Pasien:</dt>
                                <dd class="col-6" id="summary-patient">{{ Auth::user()->name }}</dd>
                                <dt class="col-6">Bayar:</dt>
                                <dd class="col-6" id="summary-payment">–</dd>
                                <dt class="col-6">Biaya:</dt>
                                <dd class="col-6 text-success fw-bold" id="summary-cost">–</dd>
                            </dl>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger btn-lg w-100">
                        <i class="fas fa-check-circle me-2"></i> Konfirmasi Janji Temu
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const doctorSelect = document.getElementById('doctor');
            const doctorInfo = document.getElementById('doctor-info');
            const otherPatientSwitch = document.getElementById('otherPatientSwitch');
            const selfPatient = document.getElementById('selfPatient');
            const otherPatient = document.getElementById('otherPatient');
            const polyclinicSelect = document.getElementById('polyclinic');
            const paymentSelect = document.getElementById('payment_method');
            const visitDateInput = document.getElementById('visit_date');

            // Handle doctor selection
            doctorSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    // Show doctor info
                    doctorInfo.classList.remove('d-none');
                    document.getElementById('doctor-specialty').textContent = selectedOption.dataset
                        .specialty;
                    document.getElementById('doctor-experience').textContent = selectedOption.dataset
                        .experience;
                    document.getElementById('doctor-schedule').textContent = selectedOption.dataset
                        .schedule;
                    document.getElementById('doctor-time').textContent = selectedOption.dataset.time;
                    document.getElementById('doctor-price').textContent = new Intl.NumberFormat('id-ID')
                        .format(selectedOption.dataset.price);

                    // Update summary
                    document.getElementById('summary-doctor').textContent = selectedOption.textContent
                        .split(' - ')[0];
                    document.getElementById('summary-cost').textContent = 'Rp ' + new Intl.NumberFormat(
                        'id-ID').format(selectedOption.dataset.price);
                } else {
                    doctorInfo.classList.add('d-none');
                    document.getElementById('summary-doctor').textContent = '-';
                    document.getElementById('summary-cost').textContent = '-';
                }
            });

            // Handle patient toggle
            otherPatientSwitch.addEventListener('change', function() {
                if (this.checked) {
                    selfPatient.classList.add('d-none');
                    otherPatient.classList.remove('d-none');
                    // Update summary patient name
                    document.getElementById('summary-patient').textContent = 'Pasien Lain';
                } else {
                    selfPatient.classList.remove('d-none');
                    otherPatient.classList.add('d-none');
                    document.getElementById('summary-patient').textContent =
                        '{{ Auth::user()->name ?? 'Pasien' }}';
                }
            });

            // Handle polyclinic selection
            polyclinicSelect.addEventListener('change', function() {
                const selectedText = this.options[this.selectedIndex].textContent;
                document.getElementById('summary-polyclinic').textContent = selectedText;
            });

            // Handle payment method selection
            paymentSelect.addEventListener('change', function() {
                const selectedText = this.options[this.selectedIndex].textContent;
                document.getElementById('summary-payment').textContent = selectedText;
            });

            // Handle visit date selection
            visitDateInput.addEventListener('change', function() {
                if (this.value) {
                    const date = new Date(this.value);
                    const options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    const formattedDate = date.toLocaleDateString('id-ID', options);

                    // Get selected doctor time
                    const doctorSelect = document.getElementById('doctor');
                    const selectedDoctor = doctorSelect.options[doctorSelect.selectedIndex];
                    const time = selectedDoctor.dataset.time || '';

                    document.getElementById('summary-schedule').textContent =
                        `${formattedDate}${time ? ' | ' + time + ' WIB' : ''}`;
                }
            });

            // Form validation
            document.getElementById('appointmentForm').addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = this.querySelectorAll('[required]');

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang wajib diisi!');
                }
            });
        });
    </script>
@endsection
