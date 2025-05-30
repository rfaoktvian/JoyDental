@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-danger">Rekam Medis Pasien</h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-danger text-white fw-bold">
            Daftar Rekam Medis
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal</th>
                        <th>Diagnosa</th>
                        <th>Tindakan</th>
                        <th>Dokter</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $data = [
                            [
                                'nama' => 'Andi Nugroho', 
                                'tanggal' => '2025-05-27', 
                                'diagnosa' => 'Hipertensi', 
                                'tindakan' => 'Pemeriksaan & Edukasi', 
                                'dokter' => 'dr. Budi',
                                'email' => 'andi.nugroho@email.com',
                                'telepon' => '081234567890',
                                'alamat' => 'Jl. Merdeka No. 123, Jakarta Pusat'
                            ],
                            [
                                'nama' => 'Siti Aminah', 
                                'tanggal' => '2025-05-25', 
                                'diagnosa' => 'Diabetes Melitus', 
                                'tindakan' => 'Cek Gula Darah & Obat', 
                                'dokter' => 'dr. Budi',
                                'email' => 'siti.aminah@email.com',
                                'telepon' => '082345678901',
                                'alamat' => 'Jl. Sudirman No. 456, Jakarta Selatan'
                            ],
                            [
                                'nama' => 'Rina Aprilia', 
                                'tanggal' => '2025-05-23', 
                                'diagnosa' => 'Asma', 
                                'tindakan' => 'Pemberian Inhaler', 
                                'dokter' => 'dr. Budi',
                                'email' => 'rina.aprilia@email.com',
                                'telepon' => '083456789012',
                                'alamat' => 'Jl. Thamrin No. 789, Jakarta Utara'
                            ],
                        ];
                    @endphp

                    @foreach ($data as $i => $medis)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $medis['nama'] }}</td>
                        <td>{{ $medis['tanggal'] }}</td>
                        <td>{{ $medis['diagnosa'] }}</td>
                        <td>{{ $medis['tindakan'] }}</td>
                        <td>{{ $medis['dokter'] }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#detailModal{{ $i }}">
                                <i class="fas fa-eye"></i> Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Detail Rekam Medis -->
                    <div class="modal fade" id="detailModal{{ $i }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $i }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="detailModalLabel{{ $i }}">Detail Rekam Medis</h5>
                                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Data Pasien -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold text-danger mb-3">
                                            <i class="fas fa-user"></i> Data Pasien
                                        </h6>
                                        <dl class="row mb-0">
                                            <dt class="col-sm-4">Nama Pasien</dt>
                                            <dd class="col-sm-8">{{ $medis['nama'] }}</dd>

                                            <dt class="col-sm-4">Email</dt>
                                            <dd class="col-sm-8">
                                                <a href="mailto:{{ $medis['email'] }}" class="text-decoration-none">
                                                    <i class="fas fa-envelope text-primary"></i> {{ $medis['email'] }}
                                                </a>
                                            </dd>

                                            <dt class="col-sm-4">No. Handphone</dt>
                                            <dd class="col-sm-8">
                                                <a href="tel:{{ $medis['telepon'] }}" class="text-decoration-none">
                                                    <i class="fas fa-phone text-success"></i> {{ $medis['telepon'] }}
                                                </a>
                                            </dd>

                                            <dt class="col-sm-4">Alamat</dt>
                                            <dd class="col-sm-8">
                                                <i class="fas fa-map-marker-alt text-warning"></i> {{ $medis['alamat'] }}
                                            </dd>
                                        </dl>
                                    </div>

                                    <hr>

                                    <!-- Data Medis -->
                                    <div class="mb-3">
                                        <h6 class="fw-bold text-danger mb-3">
                                            <i class="fas fa-stethoscope"></i> Data Medis
                                        </h6>
                                        <dl class="row mb-0">
                                            <dt class="col-sm-4">Tanggal Pemeriksaan</dt>
                                            <dd class="col-sm-8">{{ $medis['tanggal'] }}</dd>

                                            <dt class="col-sm-4">Diagnosa</dt>
                                            <dd class="col-sm-8">
                                                <span class="badge bg-info text-dark">{{ $medis['diagnosa'] }}</span>
                                            </dd>

                                            <dt class="col-sm-4">Tindakan</dt>
                                            <dd class="col-sm-8">{{ $medis['tindakan'] }}</dd>

                                            <dt class="col-sm-4">Dokter Penanggung Jawab</dt>
                                            <dd class="col-sm-8">
                                                <i class="fas fa-user-md text-primary"></i> {{ $medis['dokter'] }}
                                            </dd>

                                            <dt class="col-sm-4">Catatan Tambahan</dt>
                                            <dd class="col-sm-8 text-muted">
                                                <em><i class="fas fa-sticky-note"></i> Pasien disarankan kontrol ulang dalam 1 minggu.</em>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i> Tutup
                                    </button>
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-print"></i> Cetak
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                <small class="text-muted">* Data ini hanya dapat dilihat oleh dokter yang bersangkutan.</small>
            </div>
        </div>
    </div>
</div>
@endsection