{{-- resources/views/laporan.blade.php --}}

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
                <h4 class="fw-bold text-dark mb-1">Laporan Aktivitas</h4>
                <p class="text-muted mb-0">Ringkasan statistik dan grafik aktivitas janji temu.</p>
            </div>
        </div>

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

        @if ($period === 'daily')
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
        @endif

        <div class="row g-3 mb-4 mt-3 border-top border-1">
            <div class="col-6 col-md-3">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 me-3"
                            style="width:48px; height:48px;">
                            <span class="rounded-circle text-white d-flex align-items-center justify-content-center"
                                style="width:40px; height:40px; background-color: #ffe6e6;">
                                <i class="fas fa-user-md fs-4 text-danger"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:0.85rem;">Total Dokter</div>
                            <div class="fw-bold fs-4">{{ $totalDoctors }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 me-3"
                            style="width:48px; height:48px;">
                            <span class="rounded-circle text-white d-flex align-items-center justify-content-center"
                                style="width:40px; height:40px; background-color: #ffe6e6;">
                                <i class="fas fa-users fs-4 text-danger"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:0.85rem;">Total Pasien</div>
                            <div class="fw-bold fs-4">{{ $totalPatients }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 me-3"
                            style="width:48px; height:48px;">
                            <span class="rounded-circle text-white d-flex align-items-center justify-content-center"
                                style="width:40px; height:40px; background-color: #ffe6e6;">
                                <i class="fas fa-clinic-medical fs-4 text-danger"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:0.85rem;">Total Poliklinik</div>
                            <div class="fw-bold fs-4">{{ $totalPolyclinics }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 me-3"
                            style="width:48px; height:48px;">
                            <span class="rounded-circle text-white d-flex align-items-center justify-content-center"
                                style="width:40px; height:40px; background-color: #ffe6e6;">
                                <i class="fas fa-calendar-check fs-4 text-danger"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:0.85rem;">
                                @switch($period)
                                    @case('daily')
                                        Janji Temu {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d M Y') }}
                                    @break

                                    @case('weekly')
                                        Janji Temu {{ $weeklyLabel ?? '-' }}
                                    @break

                                    @case('monthly')
                                        Janji Temu {{ $monthLabel ?? '-' }}
                                    @break

                                    @case('yearly')
                                        Janji Temu {{ $yearLabel ?? '-' }}
                                    @break
                                @endswitch
                            </div>
                            <div class="fw-bold fs-4">{{ $appointmentsCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 me-3"
                            style="width:48px; height:48px;">
                            <span class="rounded-circle text-white d-flex align-items-center justify-content-center"
                                style="width:40px; height:40px; background-color: #ffe6e6;">
                                <i class="fas fa-coins fs-4 text-danger"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:0.85rem;">
                                @switch($period)
                                    @case('daily')
                                        Pendapatan {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d M Y') }}
                                    @break

                                    @case('weekly')
                                        Pendapatan {{ $weeklyLabel ?? '-' }}
                                    @break

                                    @case('monthly')
                                        Pendapatan {{ $monthLabel ?? '-' }}
                                    @break

                                    @case('yearly')
                                        Pendapatan {{ $yearLabel ?? '-' }}
                                    @break
                                @endswitch
                            </div>
                            <div class="fw-bold fs-4">{{ $formattedRevenue }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 me-3"
                            style="width:48px; height:48px;">
                            <span class="rounded-circle text-white d-flex align-items-center justify-content-center"
                                style="width:40px; height:40px; background-color: #ffe6e6;">
                                <i class="fas fa-star fs-4 text-danger"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:0.85rem;">Rata‐Rata Rating Dokter</div>
                            <div class="fw-bold fs-4">{{ $averageRatingAllDoctors }}/5</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm bg-white border border-1 border-mute mb-4">
            <div class="card-header bg-white fw-semibold d-flex align-items-center justify-content-between">
                <div>
                    <i class="fas fa-chart-bar me-2"></i> Grafik Janji Temu
                </div>
            </div>
            <div class="card-body" style="min-height: 300px;">
                <canvas id="appointmentsChart"></canvas>
            </div>
        </div>

        <div class="card shadow-sm bg-white border border-1 border-mute mb-4">
            <div class="card-header bg-white fw-semibold d-flex align-items-center justify-content-between">
                <div>
                    <i class="fas fa-list me-2"></i>
                    @if ($period === 'daily')
                        Detail Janji Temu {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d M Y') }}
                    @elseif($period === 'weekly')
                        Detail Janji Temu Mingguan {{ $weeklyLabel ?? '' }}
                    @elseif($period === 'monthly')
                        Detail Janji Temu Bulanan {{ $monthLabel ?? '' }}
                    @else
                        Detail Janji Temu Tahunan {{ $yearLabel ?? '' }}
                    @endif
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="appointmentsTable">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Nama Pasien</th>
                            <th>Dokter</th>
                            <th>Poliklinik</th>
                            <th class="text-center">Tanggal & Waktu</th>
                            <th class="text-center">Fee</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todayAppointments as $index => $appt)
                            <tr data-status="{{ $appt->status }}" style="background-color: #fff;">
                                <td class="bg-white text-center">{{ $index + 1 }}</td>

                                <td class="bg-white">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="fw-medium">{{ $appt->user->name }}</div>
                                            <small class="text-muted">{{ $appt->user->email }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td class="bg-white">
                                    <div class="fw-medium">{{ $appt->doctor->name }}</div>
                                    <small class="text-muted">{{ $appt->doctor->specialization ?? 'Umum' }}</small>
                                </td>

                                <td class="bg-white">
                                    @php
                                        $badge = isset($poliklinikTypes[$poliklinik->type])
                                            ? $poliklinikTypes[$poliklinik->type]
                                            : $poliklinikTypes[1];z
                                    @endphp
                                    <span class="badge {{ $badge['class'] }}">
                                        {{ optional($appt->clinic)->name ?? 'N/A' }}
                                    </span>
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
                                    <span class="fw-medium text-success">
                                        Rp {{ number_format($appt->consultation_fee ?? 0, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
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

            @if (isset($todayAppointments) && $todayAppointments->hasPages())
                <div class="card-footer bg-white border-top">
                    <nav class="d-flex justify-content-center">
                        {{ $todayAppointments->links('vendor.pagination.bootstrap-5') }}
                    </nav>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3"></script>
    <script>
        const ctx = document.getElementById('appointmentsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($dateLabels),
                datasets: [{
                    label: 'Jumlah Janji Temu',
                    data: @json($countPerDay),
                    backgroundColor: '#c62828',
                    borderColor: 'transparent',
                    borderWidth: 0,
                    borderRadius: 15,
                    barThickness: 25,
                    maxBarThickness: 30,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#9E9E9E',
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F5F5F5',
                            borderDash: [2, 2]
                        },
                        ticks: {
                            color: '#9E9E9E',
                            font: {
                                size: 12
                            },
                            stepSize: 1
                        },
                        border: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#222222',
                        titleColor: '#FFFFFF',
                        bodyColor: '#FFFFFF',
                        cornerRadius: 4,
                        displayColors: false,
                        padding: 10,
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y || 0;
                                return `${value} janji temu`;
                            }
                        }
                    }
                },
                layout: {
                    padding: {
                        top: 20,
                        bottom: 10,
                        left: 10,
                        right: 10
                    }
                }
            }
        });
    </script>
@endsection
