@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Laporan Harian</h4>
                    <p class="text-muted mb-0">Pantau aktivitas dan performa harian praktik</p>
                </div>
                <div class="d-flex gap-2">
                    <input type="date" class="form-control" id="reportDate" value="{{ date('Y-m-d') }}">
                    <button class="btn btn-outline-danger" onclick="generateReport()">
                        <i class="fas fa-sync me-2"></i>Update
                    </button>
                    <button class="btn btn-danger" onclick="printReport()">
                        <i class="fas fa-print me-2"></i>Cetak
                    </button>
                </div>
            </div>

            <!-- Date Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="fw-bold mb-1">Laporan Tanggal: <span class="text-danger">{{ date('d F Y') }}</span></h5>
                            <p class="text-muted mb-0">Ringkasan aktivitas praktik hari ini</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-flex align-items-center justify-content-end">
                                <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                    <i class="fas fa-calendar-day text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Status Hari Ini</h6>
                                    <span class="badge bg-success fs-6">Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overview Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                        <i class="fas fa-users text-primary fs-5"></i>
                                    </div>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <h6 class="text-muted mb-1">Total Pasien</h6>
                                    <h4 class="fw-bold mb-0">{{ $totalPasien ?? 24 }}</h4>
                                    <small class="text-success">
                                        <i class="fas fa-arrow-up"></i> +3 dari kemarin
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                        <i class="fas fa-check-circle text-success fs-5"></i>
                                    </div>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <h6 class="text-muted mb-1">Konsultasi Selesai</h6>
                                    <h4 class="fw-bold mb-0">{{ $konsultasiSelesai ?? 22 }}</h4>
                                    <small class="text-success">
                                        <i class="fas fa-check"></i> 91.7% completion
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                        <i class="fas fa-clock text-warning fs-5"></i>
                                    </div>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <h6 class="text-muted mb-1">Jam Praktik</h6>
                                    <h4 class="fw-bold mb-0">8.5 Jam</h4>
                                    <small class="text-muted">
                                        08:00 - 16:30 WIB
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                        <i class="fas fa-money-bill text-info fs-5"></i>
                                    </div>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <h6 class="text-muted mb-1">Pendapatan</h6>
                                    <h4 class="fw-bold mb-0">Rp 1.2M</h4>
                                    <small class="text-success">
                                        <i class="fas fa-arrow-up"></i> +15% dari rata-rata
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Patient Flow Chart -->
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="fw-bold mb-0">Alur Pasien Hari Ini</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-3">
                                    <div class="border rounded-3 p-3 mb-2 bg-primary bg-opacity-10">
                                        <i class="fas fa-user-plus text-primary fs-4 mb-2"></i>
                                        <h5 class="fw-bold">24</h5>
                                        <small class="text-muted">Registrasi</small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="border rounded-3 p-3 mb-2 bg-warning bg-opacity-10">
                                        <i class="fas fa-hourglass-half text-warning fs-4 mb-2"></i>
                                        <h5 class="fw-bold">2</h5>
                                        <small class="text-muted">Menunggu</small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="border rounded-3 p-3 mb-2 bg-success bg-opacity-10">
                                        <i class="fas fa-check-circle text-success fs-4 mb-2"></i>
                                        <h5 class="fw-bold">22</h5>
                                        <small class="text-muted">Selesai</small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="border rounded-3 p-3 mb-2 bg-secondary bg-opacity-10">