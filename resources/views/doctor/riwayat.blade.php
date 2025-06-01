@extends('layouts.app')

@section('content')
    <style>
        .nav-pills {
            gap: 0.5rem;
        }

        .nav-pills .nav-link {
            color: #6c757d;
            background-color: transparent;
            border: 1px solid transparent;
        }

        .nav-pills .nav-link:hover {
            color: #d32f2f;
        }

        .nav-pills .nav-link.active {
            color: #fff;
            background-color: #d32f2f;
            border: 1px solid #d32f2f;
        }

        .page-item .page-link {
            color: #d32f2f;
            border-radius: 0;
            min-width: 40px;
            text-align: center;
        }

        .page-item.active .page-link {
            background-color: #d32f2f;
            color: white;
            border-color: #d32f2f;
        }

        .pagination-wrapper .page-link {
            padding: .35rem .65rem;
            font-size: .825rem;
        }

        .pagination-wrapper .page-link i {
            font-size: .65rem;
            vertical-align: -1px;
        }
    </style>

    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold text-dark mb-1">Riwayat Konsultasi</h4>
                <p class="text-muted mb-0">Kelola dan lihat riwayat konsultasi pasien.</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                            style="width: 40px; aspect-ratio: 1 / 1; background-color: #ffe6e6;">
                            <i class="fas fs-5 fa-calendar-alt text-danger"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-6 text-muted mb-1">Total Konsultasi</div>
                            <div class="fs-5 fw-bold">15</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                            style="width: 40px; aspect-ratio: 1 / 1; background-color: #ffe6e6;">
                            <i class="fas fs-5 fa-calendar-alt text-danger"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-6 text-muted mb-1">Bulan Ini</div>
                            <div class="fs-5 fw-bold">15</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                            style="width: 40px; aspect-ratio: 1 / 1; background-color: #ffe6e6;">
                            <i class="fas fs-5 fa-calendar-alt text-danger"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-6 text-muted mb-1">Pasien Per Hari</div>
                            <div class="fs-5 fw-bold">15</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="card border-0 shadow-sm mb-4">
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
        </div> --}}

        <div class="d-flex align-items-center gap-2 flex-wrap justify-content-between">
            <ul class="nav nav-pills me-2 mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="fw-bold nav-link fs-6 {{ $period === 'daily' ? 'active' : '' }}"
                        href="{{ url()->current() }}?period=daily&date={{ request('date', now()->toDateString()) }}">
                        Harian
                    </a>
                </li>
                <li class="nav-item">
                    <a class="fw-bold nav-link fs-6 {{ $period === 'weekly' ? 'active' : '' }}"
                        href="{{ url()->current() }}?period=weekly">
                        Mingguan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="fw-bold nav-link fs-6 {{ $period === 'monthly' ? 'active' : '' }}"
                        href="{{ url()->current() }}?period=monthly">
                        Bulanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="fw-bold nav-link fs-6 {{ $period === 'yearly' ? 'active' : '' }}"
                        href="{{ url()->current() }}?period=yearly">
                        Tahunan
                    </a>
                </li>
            </ul>
            <div class="d-flex justify-content-end flex-grow-1">
                <button id="refreshBtn"
                    class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center ms-auto"
                    style="width:32px;height:32px" onclick="window.location.reload();" title="Refresh">
                    <i class="fa fa-sync-alt"></i>
                </button>
            </div>
        </div>
        <div class="mt-3 mb-3">
            <form action="{{ url()->current() }}" method="GET" class="mb-0">
                <input type="hidden" name="period" value="daily">
                <div class="input-group input-group-sm">
                    <input type="date" name="date" class="form-control bg-white" value="{{ $selectedDate }}"
                        max="{{ now()->toDateString() }}">
                    <button type="submit" class="btn btn-danger px-3">
                        <i class="fas fa-sync-alt me-1"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>

        <div class="custom_card shadow-sm bg-white border border-1 border-mute mb-4">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="appointmentsTable">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th class="text-center">Nama Pasien</th>
                            <th class="text-center">Email / Phone</th>
                            <th class="text-center">Umur</th>
                            <th class="text-center">Jenis Kelamin</th>
                            <th class="text-center">Tanggal & Waktu</th>
                            <th class="text-center"style="width: 70px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todayAppointments as $index => $appt)
                            <tr data-status="{{ $appt->status }}">
                                <td class="bg-white text-center">{{ $index + 1 }}</td>

                                <td class="bg-white text-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div>
                                            <div class="fw-medium">{{ $appt->user->name }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="bg-white text-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div>
                                            <small class="text-muted d-block">{{ $appt->user->email }}</small>
                                            <small class="text-muted d-block">{{ $appt->user->phone ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="bg-white text-center">
                                    @if ($appt->user->birth_date)
                                        {{ \Carbon\Carbon::parse($appt->user->birth_date)->age }} tahun
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="bg-white text-center">
                                    <div>
                                        @if ($appt->user->gender == 'woman')
                                            Perempuan
                                        @else
                                            Laki-Laki
                                        @endif
                                    </div>
                                </td>
                                <td class="bg-white text-center">
                                    <div>
                                        <div class="fw-semibold">
                                            {{ \Carbon\Carbon::parse($appt->appointment_date)->translatedFormat('d F Y') }}
                                        </div>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($appt->appointment_time)->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td class="bg-white text-center">
                                    <button class="btn btn-sm btn-outline-secondary" {{-- data-modal-url="{{ route('admin.dokter.edit', ['id' => $doctor->id]) }}" --}}
                                        data-modal-title="Ubah Data Dokter" style="width: 36px; height: 36px; padding: 0;">
                                        <i class="fas fa-cog fs-5"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5 bg-white">
                                    <i class="fas fa-calendar-times fa-3x mb-3 text-muted opacity-50"></i><br>
                                    <h6 class="text-muted">Tidak ada janji temu</h6>
                                    <p class="mb-0">
                                        untuk tanggal
                                        {{ \Carbon\Carbon::parse($selectedDate ?? now())->translatedFormat('d F Y') }}
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if (isset($todayAppointments) && $todayAppointments->hasPages())
            <nav class="d-flex justify-content-center">
                {{ $todayAppointments->links('vendor.pagination.bootstrap-5') }}
            </nav>
        @endif
    </div>
@endsection
