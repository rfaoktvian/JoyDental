@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Profil Dokter</h4>
                    <p class="text-muted mb-0">Kelola informasi pribadi dan jadwal praktik</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-danger" onclick="resetForm()">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                    <button class="btn btn-danger" onclick="saveProfile()">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>

            <div class="row">
                <!-- Profile Information -->
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="position-relative mb-3">
                                <img src="{{ asset('images/doctors_login.png') }}" 
                                     alt="Profile Photo" 
                                     class="rounded-circle mb-3"
                                     style="width: 120px; height: 120px; object-fit: cover;"
                                     id="profilePhoto">
                                <button class="btn btn-sm btn-danger rounded-circle position-absolute" 
                                        style="bottom: 10px; right: calc(50% - 70px);"
                                        onclick="changePhoto()">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                            <h5 class="fw-bold mb-1">{{ $doctor->name ?? 'Dr. Ahmad Susanto' }}</h5>
                            <p class="text-muted mb-3">{{ $doctor->specialization ?? 'Dokter Umum' }}</p>
                            
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="border-end">
                                        <h6 class="fw-bold text-primary mb-0">{{ $doctor->total_patients ?? 1247 }}</h6>
                                        <small class="text-muted">Pasien</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border-end">
                                        <h6 class="fw-bold text-success mb-0">{{ $doctor->experience ?? 8 }}</h6>
                                        <small class="text-muted">Tahun</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <h6 class="fw-bold text-warning mb-0">4.9</h6>
                                    <small class="text-muted">Rating</small>
                                </div>
                            </div>

                            <hr>

                            <div class="text-start">
                                <h6 class="fw-bold mb-3">Informasi Kontak</h6>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-envelope text-muted me-3"></i>
                                    <span>{{ $doctor->email ?? 'ahmad.susanto@email.com' }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-phone text-muted me-3"></i>
                                    <span>{{ $doctor->phone ?? '+62 812-3456-7890' }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-id-card text-muted me-3"></i>
                                    <span>{{ $doctor->license_number ?? 'SIP.123456789' }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar text-muted me-3"></i>
                                    <span>Bergabung {{ $doctor->joined_date ?? 'Jan 2020' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Form -->
                <div class="col-lg-8">
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-0 py-3">
                                    <h6 class="fw-bold mb-0">Informasi Pribadi</h6>
                                </div>
                                <div class="card-body">
                                    <form id="profileForm">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Nama Lengkap *</label>
                                                <input type="text" class="form-control" 
                                                       value="{{ $doctor->name ?? 'Dr. Ahmad Susanto' }}"
                                                       name="name" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Spesialisasi *</label>
                                                <select class="form-select" name="specialization" required>
                                                    <option value="Dokter Umum" selected>Dokter Umum</option>
                                                    <option value="Dokter Anak">Dokter Anak</option>
                                                    <option value="Dokter Kandungan">Dokter Kandungan</option>
                                                    <option value="Dokter Jantung">Dokter Jantung</option>
                                                    <option value="Dokter Mata">Dokter Mata</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Email *</label>
                                                <input type="email" class="form-control" 
                                                       value="{{ $doctor->email ?? 'ahmad.susanto@email.com' }}"
                                                       name="email" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Nomor Telepon *</label>
                                                <input type="tel" class="form-control" 
                                                       value="{{ $doctor->phone ?? '+62 812-3456-7890' }}"
                                                       name="phone" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Nomor SIP *</label>
                                                <input type="text" class="form-control" 
                                                       value="{{ $doctor->license_number ?? 'SIP.123456789' }}"
                                                       name="license_number" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Pengalaman (Tahun)</label>
                                                <input type="number" class="form-control" 
                                                       value="{{ $doctor->experience ?? 8 }}"
                                                       name="experience" min="0">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-semibold">Alamat</label>
                                                <textarea class="form-control" rows="3" name="address" 
                                                          placeholder="Masukkan alamat lengkap">{{ $doctor->address ?? 'Jl. Kesehatan No. 123, Jakarta Selatan, DKI Jakarta 12345' }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">Bio/Deskripsi</label>
                                                <textarea class="form-control" rows="4" name="bio" 
                                                          placeholder="Ceritakan tentang diri Anda, pengalaman, dan keahlian">{{ $doctor->bio ?? 'Dokter umum berpengalaman dengan fokus pada pelayanan kesehatan primer dan pencegahan penyakit. Menangani berbagai kondisi medis dengan pendekatan holistik.' }}</textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Management -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold mb-0">Jadwal Praktik</h6>
                                    <button class="btn btn-sm btn-outline-danger" onclick="addSchedule()">
                                        <i class="fas fa-plus me-1"></i>Tambah Jadwal
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="scheduleContainer">
                                        <!-- Monday -->
                                        <div class="row align-items-center mb-3 schedule-row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="monday" checked>
                                                    <label class="form-check-label fw-semibold" for="monday">Senin</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="08:00" name="monday_start">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <span class="text-muted">sampai</span>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="16:00" name="monday_end">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control" value="20" placeholder="Kuota" name="monday_quota">
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Tuesday -->
                                        <div class="row align-items-center mb-3 schedule-row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="tuesday" checked>
                                                    <label class="form-check-label fw-semibold" for="tuesday">Selasa</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="08:00" name="tuesday_start">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <span class="text-muted">sampai</span>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="16:00" name="tuesday_end">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control" value="20" placeholder="Kuota" name="tuesday_quota">
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Wednesday -->
                                        <div class="row align-items-center mb-3 schedule-row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="wednesday" checked>
                                                    <label class="form-check-label fw-semibold" for="wednesday">Rabu</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="08:00" name="wednesday_start">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <span class="text-muted">sampai</span>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="16:00" name="tuesday_end">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control" value="20" placeholder="Kuota" name="tuesday_quota">
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                    <!-- Lanjutan Schedule Management - Kamis sampai Minggu -->
                                        <!-- Thursday -->
                                        <div class="row align-items-center mb-3 schedule-row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="thursday" checked>
                                                    <label class="form-check-label fw-semibold" for="thursday">Kamis</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="08:00" name="thursday_start">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <span class="text-muted">sampai</span>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="16:00" name="thursday_end">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control" value="20" placeholder="Kuota" name="thursday_quota">
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Friday -->
                                        <div class="row align-items-center mb-3 schedule-row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="friday" checked>
                                                    <label class="form-check-label fw-semibold" for="friday">Jumat</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="08:00" name="friday_start">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <span class="text-muted">sampai</span>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="16:00" name="friday_end">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control" value="20" placeholder="Kuota" name="friday_quota">
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Saturday -->
                                        <div class="row align-items-center mb-3 schedule-row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="saturday">
                                                    <label class="form-check-label fw-semibold" for="saturday">Sabtu</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="08:00" name="saturday_start" disabled>
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <span class="text-muted">sampai</span>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="13:00" name="saturday_end" disabled>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control" value="15" placeholder="Kuota" name="saturday_quota" disabled>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                                    <i class="fas fa-eye-slash"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Sunday -->
                                        <div class="row align-items-center mb-3 schedule-row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="sunday">
                                                    <label class="form-check-label fw-semibold" for="sunday">Minggu</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="09:00" name="sunday_start" disabled>
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <span class="text-muted">sampai</span>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" class="form-control" value="14:00" name="sunday_end" disabled>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control" value="10" placeholder="Kuota" name="sunday_quota" disabled>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-sm btn-outline-secondary" onclick="toggleSchedule(this)">
                                                    <i class="fas fa-eye-slash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

<!-- Photo Upload Modal -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div id="photoPreview" class="mb-3">
                    <img src="{{ asset('images/doctors_login.png') }}" 
                         alt="Preview" 
                         class="rounded-circle"
                         style="width: 150px; height: 150px; object-fit: cover;"
                         id="previewImage">
                </div>
                <input type="file" class="form-control" id="photoInput" accept="image/*" onchange="previewPhoto(this)">
                <small class="text-muted d-block mt-2">Format: JPG, PNG, GIF. Maksimal 2MB</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="uploadPhoto()">Upload</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
// Global variables
let originalFormData = {};

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Store original form data
    storeOriginalData();
    
    // Setup checkbox listeners for schedule
    setupScheduleListeners();
    
    // Setup form validation
    setupFormValidation();
});

// Store original form data for reset functionality
function storeOriginalData() {
    const form = document.getElementById('profileForm');
    const formData = new FormData(form);
    
    originalFormData = {};
    for (let [key, value] of formData.entries()) {
        originalFormData[key] = value;
    }
    
    // Store schedule data
    const scheduleInputs = document.querySelectorAll('#scheduleContainer input');
    scheduleInputs.forEach(input => {
        if (input.type === 'checkbox') {
            originalFormData[input.id] = input.checked;
        } else {
            originalFormData[input.name] = input.value;
        }
    });
}

// Setup schedule checkbox listeners
function setupScheduleListeners() {
    const checkboxes = document.querySelectorAll('#scheduleContainer input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const row = this.closest('.schedule-row');
            const inputs = row.querySelectorAll('input[type="time"], input[type="number"]');
            const button = row.querySelector('button i');
            
            if (this.checked) {
                inputs.forEach(input => input.disabled = false);
                button.className = 'fas fa-eye';
                row.style.opacity = '1';
            } else {
                inputs.forEach(input => input.disabled = true);
                button.className = 'fas fa-eye-slash';
                row.style.opacity = '0.6';
            }
        });
    });
}

// Setup form validation
function setupFormValidation() {
    const form = document.getElementById('profileForm');
    const inputs = form.querySelectorAll('input[required], select[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', validateInput);
        input.addEventListener('input', clearValidation);
    });
}

// Validate individual input
function validateInput(e) {
    const input = e.target;
    const value = input.value.trim();
    
    // Remove existing validation classes
    input.classList.remove('is-valid', 'is-invalid');
    
    if (!value) {
        input.classList.add('is-invalid');
        showInputError(input, 'Field ini wajib diisi!');
        return false;
    }
    
    // Email validation
    if (input.type === 'email') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            input.classList.add('is-invalid');
            showInputError(input, 'Format email tidak valid!');
            return false;
        }
    }
    
    // Phone validation
    if (input.type === 'tel') {
        const phoneRegex = /^(\+62|62|0)[0-9]{9,12}$/;
        if (!phoneRegex.test(value.replace(/[\s-]/g, ''))) {
            input.classList.add('is-invalid');
            showInputError(input, 'Format nomor telepon tidak valid!');
            return false;
        }
    }
    
    input.classList.add('is-valid');
    clearInputError(input);
    return true;
}

// Clear validation styling
function clearValidation(e) {
    const input = e.target;
    input.classList.remove('is-valid', 'is-invalid');
    clearInputError(input);
}

// Show input error
function showInputError(input, message) {
    clearInputError(input);
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback';
    errorDiv.textContent = message;
    input.parentNode.appendChild(errorDiv);
}

// Clear input error
function clearInputError(input) {
    const existingError = input.parentNode.querySelector('.invalid-feedback');
    if (existingError) {
        existingError.remove();
    }
}

// Save profile function
function saveProfile() {
    // Validate form
    const form = document.getElementById('profileForm');
    const requiredInputs = form.querySelectorAll('input[required], select[required]');
    let isValid = true;
    
    requiredInputs.forEach(input => {
        if (!validateInput({ target: input })) {
            isValid = false;
        }
    });
    
    if (!isValid) {
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            text: 'Mohon periksa kembali data yang Anda masukkan!'
        });
        return;
    }
    
    // Show loading
    Swal.fire({
        title: 'Menyimpan...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Simulate API call
    setTimeout(() => {
        // Collect form data
        const formData = new FormData(form);
        
        // Collect schedule data
        const scheduleData = {};
        const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        
        days.forEach(day => {
            const checkbox = document.getElementById(day);
            scheduleData[day] = {
                active: checkbox.checked,
                start: document.querySelector(`input[name="${day}_start"]`).value,
                end: document.querySelector(`input[name="${day}_end"]`).value,
                quota: document.querySelector(`input[name="${day}_quota"]`).value
            };
        });
        
        // Here you would typically send data to server
        console.log('Profile Data:', Object.fromEntries(formData));
        console.log('Schedule Data:', scheduleData);
        
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Profil berhasil diperbarui',
            timer: 2000,
            showConfirmButton: false
        });
        
        // Update stored original data
        storeOriginalData();
        
    }, 1500);
}

// Reset form function
function resetForm() {
    Swal.fire({
        title: 'Reset Form?',
        text: 'Semua perubahan akan dikembalikan ke data awal',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Reset',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Reset form inputs
            const form = document.getElementById('profileForm');
            const inputs = form.querySelectorAll('input, select, textarea');
            
            inputs.forEach(input => {
                if (originalFormData[input.name]) {
                    input.value = originalFormData[input.name];
                }
                input.classList.remove('is-valid', 'is-invalid');
            });
            
            // Reset schedule checkboxes
            const checkboxes = document.querySelectorAll('#scheduleContainer input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = originalFormData[checkbox.id] || false;
                checkbox.dispatchEvent(new Event('change'));
            });
            
            // Clear all error messages
            document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            
            Swal.fire({
                icon: 'success',
                title: 'Form direset!',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}

// Change photo function
function changePhoto() {
    const modal = new bootstrap.Modal(document.getElementById('photoModal'));
    modal.show();
}

// Preview photo before upload
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar',
                text: 'Ukuran file maksimal 2MB'
            });
            input.value = '';
            return;
        }
        
        // Validate file type
        if (!file.type.startsWith('image/')) {
            Swal.fire({
                icon: 'error',
                title: 'Format File Salah',
                text: 'Hanya file gambar yang diizinkan'
            });
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Upload photo function
function uploadPhoto() {
    const input = document.getElementById('photoInput');
    
    if (!input.files || !input.files[0]) {
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Foto',
            text: 'Silakan pilih foto terlebih dahulu'
        });
        return;
    }
    
    // Show loading
    Swal.fire({
        title: 'Mengupload...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Simulate upload
    setTimeout(() => {
        const newImageSrc = document.getElementById('previewImage').src;
        document.getElementById('profilePhoto').src = newImageSrc;
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('photoModal'));
        modal.hide();
        
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Foto profil berhasil diperbarui',
            timer: 2000,
            showConfirmButton: false
        });
        
        // Reset input
        input.value = '';
        
    }, 2000);
}

// Toggle schedule visibility
function toggleSchedule(button) {
    const row = button.closest('.schedule-row');
    const checkbox = row.querySelector('input[type="checkbox"]');
    const icon = button.querySelector('i');
    
    checkbox.checked = !checkbox.checked;
    checkbox.dispatchEvent(new Event('change'));
}

// Add new schedule (future enhancement)
function addSchedule() {
    Swal.fire({
        icon: 'info',
        title: 'Fitur Segera Hadir',
        text: 'Fitur tambah jadwal khusus akan segera tersedia'
    });
}
</script>

<!-- Additional CSS -->
<style>
.schedule-row {
    transition: opacity 0.3s ease;
}

.schedule-row:hover {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 8px;
    margin: 0 -8px;
}

.form-control:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
}

.form-select:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.text-primary { color: #007bff !important; }
.text-success { color: #28a745 !important; }
.text-warning { color: #ffc107 !important; }

@media (max-width: 768px) {
    .schedule-row .col-md-1 {
        text-align: center;
        margin-top: 10px;
    }
    
    .schedule-row .col-md-2 {
        margin-bottom: 10px;
    }
}
</style>