@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-danger text-white">
                    <h2 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Form Pendaftaran Janji Temu</h2>
                </div>
                <div class="card-body p-4">
                    <form id="appointmentForm" action="{{ route('janji-temu.store') }}" method="POST">
                        @csrf
                        
                        <!-- Bagian 1: Pilih Poliklinik -->
                        <div class="mb-5">
                            <h4 class="text-danger border-bottom border-danger pb-2 mb-4">
                                <i class="fas fa-hospital me-2"></i>Pilih Poliklinik
                            </h4>
                            <div class="mb-4">
                                <label for="polyclinic" class="form-label fw-bold">Daftar Poliklinik <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg @error('polyclinic') is-invalid @enderror" 
                                        id="polyclinic" name="polyclinic" required>
                                    <option value="" selected disabled>Pilih Poliklinik</option>
                                    <option value="1" {{ old('polyclinic') == '1' ? 'selected' : '' }}>Klinik Anak (Pediatric)</option>
                                    <option value="2" {{ old('polyclinic') == '2' ? 'selected' : '' }}>Klinik Dokter Gigi (Surgical)</option>
                                    <option value="3" {{ old('polyclinic') == '3' ? 'selected' : '' }}>Klinik Bedah Mulut (Surgical)</option>
                                    <option value="4" {{ old('polyclinic') == '4' ? 'selected' : '' }}>Klinik Penyakit Dalam (Internal Medicine)</option>
                                    <option value="5" {{ old('polyclinic') == '5' ? 'selected' : '' }}>Klinik Mata (Ophthalmology)</option>
                                    <option value="6" {{ old('polyclinic') == '6' ? 'selected' : '' }}>Klinik Jantung (Cardiology)</option>
                                </select>
                                @error('polyclinic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Pilih poliklinik yang akan Anda kunjungi</div>
                            </div>
                        </div>
                        
                        <!-- Bagian 2: Pilih Dokter dan Jadwal -->
                        <div class="mb-5">
                            <h4 class="text-danger border-bottom border-danger pb-2 mb-4">
                                <i class="fas fa-user-md me-2"></i>Pilih Dokter dan Jadwal
                            </h4>
                            
                            <div class="mb-4">
                                <label for="doctor" class="form-label fw-bold">Dokter yang Tersedia <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg @error('doctor') is-invalid @enderror" 
                                        id="doctor" name="doctor" required>
                                    <option value="" selected disabled>Pilih Dokter</option>
                                    <option value="1" data-specialty="Pediatric" data-experience="12" data-schedule="Sel, Kam" 
                                            data-time="09:00 - 14:00" data-price="225000" {{ old('doctor') == '1' ? 'selected' : '' }}>
                                        Dr. Amanda Wijaya - Spesialis Pediatric (12 tahun pengalaman) - Rp 225.000
                                    </option>
                                    <option value="2" data-specialty="Surgical" data-experience="10" data-schedule="Sel, Kam" 
                                            data-time="10:00 - 15:00" data-price="235000" {{ old('doctor') == '2' ? 'selected' : '' }}>
                                        Dr. Jason Santoso - Spesialis Surgical (10 tahun pengalaman) - Rp 235.000
                                    </option>
                                    <option value="3" data-specialty="Pediatric" data-experience="8" data-schedule="Sen, Rab, Jum" 
                                            data-time="13:00 - 17:00" data-price="210000" {{ old('doctor') == '3' ? 'selected' : '' }}>
                                        Dr. Dian Pratiwi - Spesialis Pediatric (8 tahun pengalaman) - Rp 210.000
                                    </option>
                                </select>
                                @error('doctor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Info Dokter Terpilih -->
                            <div id="doctor-info" class="card bg-light d-none mb-4">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">Informasi Dokter Terpilih:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Spesialisasi:</strong> <span id="doctor-specialty">-</span></p>
                                            <p class="mb-1"><strong>Pengalaman:</strong> <span id="doctor-experience">-</span> tahun</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Jadwal:</strong> <span id="doctor-schedule">-</span></p>
                                            <p class="mb-1"><strong>Jam Praktek:</strong> <span id="doctor-time">-</span></p>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-success"><strong>Biaya Konsultasi: Rp <span id="doctor-price">-</span></strong></p>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="visit_date" class="form-label fw-bold">Tanggal Kunjungan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-lg @error('visit_date') is-invalid @enderror" 
                                       id="visit_date" name="visit_date" min="{{ date('Y-m-d') }}" 
                                       value="{{ old('visit_date') }}" required>
                                @error('visit_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Bagian 3: Identitas Pasien -->
                        <div class="mb-5">
                            <h4 class="text-danger border-bottom border-danger pb-2 mb-4">
                                <i class="fas fa-user me-2"></i>Identitas Pasien
                            </h4>
                            
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label fw-bold m-0">Pilih Pasien</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="otherPatientSwitch">
                                        <label class="form-check-label" for="otherPatientSwitch">Pasien Lain</label>
                                    </div>
                                </div>
                                
                                <!-- Pasien Sendiri -->
                                <div id="selfPatient">
                                    <div class="card border-success">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h5 class="card-title mb-1">{{ Auth::user()->name ?? 'Walidddd' }}</h5>
                                                    <p class="card-text mb-1">NIK: {{ Auth::user()->nik ?? '3173011509950001' }}</p>
                                                    <p class="card-text mb-0">{{ Auth::user()->gender ?? 'Laki-laki' }}, {{ Auth::user()->age ?? '30' }} tahun</p>
                                                </div>
                                                <span class="badge bg-success fs-6">Pribadi</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Pasien Lain -->
                                <div id="otherPatient" class="d-none">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="patient_name" value="{{ old('patient_name') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="patient_nik" value="{{ old('patient_nik') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <select class="form-select" name="patient_gender">
                                                <option value="" selected disabled>Pilih</option>
                                                <option value="L" {{ old('patient_gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old('patient_gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="patient_birthdate" value="{{ old('patient_birthdate') }}">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                            <textarea class="form-control" rows="3" name="patient_address">{{ old('patient_address') }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">No. Handphone <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" name="patient_phone" value="{{ old('patient_phone') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Keluhan <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('complaint') is-invalid @enderror" rows="4" 
                                          name="complaint" placeholder="Deskripsikan keluhan Anda secara detail..." required>{{ old('complaint') }}</textarea>
                                @error('complaint')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Bagian 4: Cara Bayar -->
                        <div class="mb-5">
                            <h4 class="text-danger border-bottom border-danger pb-2 mb-4">
                                <i class="fas fa-credit-card me-2"></i>Cara Bayar
                            </h4>
                            
                            <div class="mb-4">
                                <label for="payment_method" class="form-label fw-bold">Pilih Metode Pembayaran <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg @error('payment_method') is-invalid @enderror" 
                                        id="payment_method" name="payment_method" required>
                                    <option value="" selected disabled>Pilih Metode Pembayaran</option>
                                    <option value="umum" {{ old('payment_method') == 'umum' ? 'selected' : '' }}>
                                        <i class="fas fa-hand-holding-medical"></i> Tanpa Asuransi/Umum
                                    </option>
                                    <option value="rujuk_internal" {{ old('payment_method') == 'rujuk_internal' ? 'selected' : '' }}>
                                        <i class="fas fa-credit-card"></i> Rujuk Internal
                                    </option>
                                    <option value="jasa_raharja" {{ old('payment_method') == 'jasa_raharja' ? 'selected' : '' }}>
                                        <i class="fas fa-money-bill-wave"></i> PT. Jasa Raharja
                                    </option>
                                    <option value="inhealt" {{ old('payment_method') == 'inhealt' ? 'selected' : '' }}>
                                        <i class="fas fa-building"></i> Inhealt
                                    </option>
                                    <option value="kereta_api" {{ old('payment_method') == 'kereta_api' ? 'selected' : '' }}>
                                        <i class="fas fa-building"></i> PT. Kereta Api Indonesia
                                    </option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Informasi Penting -->
                        <div class="alert alert-info d-flex align-items-start mb-4" role="alert">
                            <i class="fas fa-info-circle me-3 mt-1"></i>
                            <div>
                                <h6 class="alert-heading">Informasi Penting:</h6>
                                <p class="mb-0">Pasien setelah mendaftar diharap untuk datang 15 menit sebelum waktu yang telah ditentukan. 
                                Jika pasien tidak hadir dalam waktu 30 menit setelah waktu yang ditentukan, maka janji temu akan dibatalkan secara otomatis.</p>
                            </div>
                        </div>
                        
                        <!-- Ringkasan Pemesanan -->
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0"><i class="fas fa-clipboard-list me-2"></i>Ringkasan Pemesanan</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <dl class="row mb-0">
                                            <dt class="col-sm-5">Poliklinik:</dt>
                                            <dd class="col-sm-7" id="summary-polyclinic">-</dd>
                                            
                                            <dt class="col-sm-5">Dokter:</dt>
                                            <dd class="col-sm-7" id="summary-doctor">-</dd>
                                            
                                            <dt class="col-sm-5">Jadwal:</dt>
                                            <dd class="col-sm-7" id="summary-schedule">-</dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6">
                                        <dl class="row mb-0">
                                            <dt class="col-sm-5">Pasien:</dt>
                                            <dd class="col-sm-7" id="summary-patient">{{ Auth::user()->name ?? 'Walidddd' }}</dd>
                                            
                                            <dt class="col-sm-5">Pembayaran:</dt>
                                            <dd class="col-sm-7" id="summary-payment">-</dd>
                                            
                                            <dt class="col-sm-5">Biaya:</dt>
                                            <dd class="col-sm-7 text-success fw-bold" id="summary-cost">-</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-danger btn-lg px-5">
                                <i class="fas fa-check-circle me-2"></i>Konfirmasi Janji Temu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
            document.getElementById('doctor-specialty').textContent = selectedOption.dataset.specialty;
            document.getElementById('doctor-experience').textContent = selectedOption.dataset.experience;
            document.getElementById('doctor-schedule').textContent = selectedOption.dataset.schedule;
            document.getElementById('doctor-time').textContent = selectedOption.dataset.time;
            document.getElementById('doctor-price').textContent = new Intl.NumberFormat('id-ID').format(selectedOption.dataset.price);
            
            // Update summary
            document.getElementById('summary-doctor').textContent = selectedOption.textContent.split(' - ')[0];
            document.getElementById('summary-cost').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(selectedOption.dataset.price);
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
            document.getElementById('summary-patient').textContent = '{{ Auth::user()->name ?? "Walidddd" }}';
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
            
            document.getElementById('summary-schedule').textContent = `${formattedDate}${time ? ' | ' + time + ' WIB' : ''}`;
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

<style>
.card {
    border-radius: 10px;
}

.form-select, .form-control {
    border-radius: 8px;
}

.btn-danger {
    background: linear-gradient(45deg, #dc3545, #c82333);
    border: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.alert {
    border-radius: 8px;
    border: none;
}

.badge {
    border-radius: 20px;
}

#doctor-info {
    border-left: 4px solid #007bff;
}

.form-select:focus, .form-control:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}
</style>
@endsection