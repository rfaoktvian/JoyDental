@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Riwayat Konsultasi</h4>
                    <p class="text-muted mb-0">Kelola dan lihat riwayat konsultasi pasien</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <button class="btn btn-danger" onclick="exportData()">
                        <i class="fas fa-download me-2"></i>Export
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                        <i class="fas fa-user-md text-primary fs-5"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-muted mb-1">Total Konsultasi</h6>
                                    <h4 class="fw-bold mb-0">{{ $totalKonsultasi ?? 156 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                        <i class="fas fa-calendar-check text-success fs-5"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-muted mb-1">Bulan Ini</h6>
                                    <h4 class="fw-bold mb-0">{{ $bulanIni ?? 23 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                        <i class="fas fa-clock text-warning fs-5"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-muted mb-1">Rata-rata/Hari</h6>
                                    <h4 class="fw-bold mb-0">{{ $rataRata ?? 8 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                        <i class="fas fa-chart-line text-info fs-5"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-muted mb-1">Pertumbuhan</h6>
                                    <h4 class="fw-bold mb-0 text-success">+12%</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light" 
                                       placeholder="Cari nama pasien, diagnosis..." id="searchInput">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select border-0 bg-light" id="statusFilter">
                                <option value="">Semua Status</option>
                                <option value="selesai">Selesai</option>
                                <option value="batal">Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control border-0 bg-light" id="dateFilter">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-secondary w-100" onclick="resetFilter()">
                                <i class="fas fa-refresh me-2"></i>Reset Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consultation History Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">Pasien</th>
                                    <th class="border-0 px-4 py-3">Tanggal & Waktu</th>
                                    <th class="border-0 px-4 py-3">Diagnosis</th>
                                    <th class="border-0 px-4 py-3">Status</th>
                                    <th class="border-0 px-4 py-3">Tindakan</th>
                                    <th class="border-0 px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Sample Data -->
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <span class="fw-bold">AD</span>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 fw-semibold">Ahmad Dahlan</h6>
                                                <small class="text-muted">ID: P001</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="fw-semibold">15 Nov 2024</div>
                                            <small class="text-muted">14:30 WIB</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-danger bg-opacity-10 text-danger">Hipertensi</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-success">Selesai</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <small class="text-muted">Pemberian obat, kontrol rutin</small>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" onclick="viewDetail('P001')">
                                                    <i class="fas fa-eye me-2"></i>Lihat Detail</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="printReceipt('P001')">
                                                    <i class="fas fa-print me-2"></i>Cetak Resep</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <span class="fw-bold">SF</span>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 fw-semibold">Siti Fatimah</h6>
                                                <small class="text-muted">ID: P002</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="fw-semibold">14 Nov 2024</div>
                                            <small class="text-muted">10:15 WIB</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-warning bg-opacity-10 text-warning">Diabetes</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-success">Selesai</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <small class="text-muted">Penyesuaian dosis, diet</small>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" onclick="viewDetail('P002')">
                                                    <i class="fas fa-eye me-2"></i>Lihat Detail</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="printReceipt('P002')">
                                                    <i class="fas fa-print me-2"></i>Cetak Resep</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <span class="fw-bold">BW</span>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 fw-semibold">Budi Wicaksono</h6>
                                                <small class="text-muted">ID: P003</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="fw-semibold">13 Nov 2024</div>
                                            <small class="text-muted">16:45 WIB</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">Check Up</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-secondary">Dibatalkan</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <small class="text-muted">-</small>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" onclick="viewDetail('P003')">
                                                    <i class="fas fa-eye me-2"></i>Lihat Detail</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center p-4 border-top">
                        <div class="text-muted">
                            Menampilkan 1-10 dari 156 konsultasi
                        </div>
                        <nav>
                            <ul class="pagination mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Konsultasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Informasi Pasien</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted">Nama</td>
                                <td>: <span id="patientName">-</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Umur</td>
                                <td>: <span id="patientAge">-</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Jenis Kelamin</td>
                                <td>: <span id="patientGender">-</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Informasi Konsultasi</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted">Tanggal</td>
                                <td>: <span id="consultDate">-</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Waktu</td>
                                <td>: <span id="consultTime">-</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status</td>
                                <td>: <span id="consultStatus">-</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="fw-bold mb-3">Keluhan & Diagnosis</h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                <p class="mb-2"><strong>Keluhan:</strong></p>
                                <p id="complaint" class="text-muted">-</p>
                                <p class="mb-2"><strong>Diagnosis:</strong></p>
                                <p id="diagnosis" class="text-muted">-</p>
                                <p class="mb-2"><strong>Resep:</strong></p>
                                <p id="prescription" class="text-muted">-</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" onclick="printReceipt()">
                    <i class="fas fa-print me-2"></i>Cetak Resep
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function viewDetail(patientId) {
    // Sample data - replace with actual API call
    const sampleData = {
        'P001': {
            name: 'Ahmad Dahlan',
            age: '45 tahun',
            gender: 'Laki-laki',
            date: '15 November 2024',
            time: '14:30 WIB',
            status: 'Selesai',
            complaint: 'Pusing, mual, dan tekanan darah tinggi',
            diagnosis: 'Hipertensi Stadium 2',
            prescription: 'Amlodipine 10mg 1x1, Captopril 25mg 2x1'
        }
    };
    
    const data = sampleData[patientId];
    if (data) {
        document.getElementById('patientName').textContent = data.name;
        document.getElementById('patientAge').textContent = data.age;
        document.getElementById('patientGender').textContent = data.gender;
        document.getElementById('consultDate').textContent = data.date;
        document.getElementById('consultTime').textContent = data.time;
        document.getElementById('consultStatus').textContent = data.status;
        document.getElementById('complaint').textContent = data.complaint;
        document.getElementById('diagnosis').textContent = data.diagnosis;
        document.getElementById('prescription').textContent = data.prescription;
        
        new bootstrap.Modal(document.getElementById('detailModal')).show();
    }
}

function printReceipt(patientId) {
    alert('Fitur cetak resep untuk pasien: ' + patientId);
}

function exportData() {
    alert('Export data riwayat konsultasi');
}

function resetFilter() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('dateFilter').value = '';
}

// Real-time search
document.getElementById('searchInput').addEventListener('input', function() {
    // Implement search functionality
    console.log('Searching for:', this.value);
});
</script>
@endsection