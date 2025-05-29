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

    @php
        use App\Enums\AppointmentStatus;

        $tabs = [
            'all' => ['label' => 'Semua', 'color' => '', 'count' => $statusCount->sum()],
            'upcoming' => [
                'label' => 'Akan Datang',
                'count' => $statusCount[AppointmentStatus::Upcoming->value] ?? 0,
            ],
            'completed' => [
                'label' => 'Selesai',
                'count' => $statusCount[AppointmentStatus::Completed->value] ?? 0,
            ],
            'canceled' => [
                'label' => 'Dibatalkan',
                'count' => $statusCount[AppointmentStatus::Canceled->value] ?? 0,
            ],
        ];
    @endphp

    <div class="container">

        <div class="border-bottom mb-3 pb-2 sticky-top pt-3 px-1" style="background: #F5F5F5; ">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                <input type="text" name="q" value="{{ $search }}" class="form-control form-control-sm w-auto"
                    placeholder="Cari pasien…" hx-get="{{ url()->current() }}" hx-trigger="keyup changed delay:300ms"
                    hx-target="#page-content" hx-push-url="true">
                <select name="clinic" class="form-select form-select-sm w-auto" hx-get="{{ url()->current() }}"
                    hx-trigger="change" hx-target="#page-content" hx-push-url="true">
                    <option value="">Semua Poliklinik</option>
                    @foreach ($appointments->pluck('clinic.name')->unique() as $clinicName)
                        <option value="{{ $clinicName }}" {{ $clinicName == $clinic ? 'selected' : '' }}>
                            {{ $clinicName }}
                        </option>
                    @endforeach
                </select>
            </div>

            <ul class="nav nav-pills small fw-bold align-items-center" id="statusTabs" style="gap:.5rem">
                <span class="fw-semibold">Status</span>

                @foreach ($tabs as $key => $t)
                    <li class="nav-item">
                        <a href="{{ request()->fullUrlWithQuery(['tab' => $key, 'page' => 1]) }}" {{-- link fallback (non-JS) --}}
                            class="nav-link {{ $key === $currentTab ? 'active' : '' }}"
                            hx-get="{{ request()->fullUrlWithQuery(['tab' => $key, 'page' => 1]) }}" {{-- load via HTMX --}}
                            hx-target="#page-content" hx-push-url="true">
                            {{ $t['label'] }}
                            <span class="badge bg-danger border border-1 border-white ms-1">{{ $t['count'] }}</span>
                        </a>
                    </li>
                @endforeach

                <li class="ms-auto">
                    <button id="refreshBtn"
                        class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center p-0"
                        style="width:32px;height:32px" hx-get="{{ request()->fullUrl() }}" {{-- ← pertahankan tab & filter --}}
                        hx-target="#page-content" hx-swap="outerHTML" hx-indicator="#htmx-indicator" title="Refresh">
                        <i class="fa fa-sync-alt m-auto"></i>
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content">

            @foreach ($tabs as $key => $tab)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }} pt-2" id="pane-{{ $key }}"
                    role="tabpanel">

                    <div class="row g-4" id="grid-{{ $key }}">
                        @forelse ($appointments->when($key!=='all',fn($q) => $q->where('status',
                        AppointmentStatus::fromLabel($key))) as $appt)
                        <div class="col-12 col-md-6 col-lg-4 appt-card" data-clinic="{{ $appt->clinic->name }}"
                            data-name="{{ Str::lower($appt->patient->name) }}">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body small">
                                    <div class="d-flex justify-content-between mb-1">
                                        <div>
                                            <h6 class="fw-semibold mb-0">{{ $appt->patient->name }}</h6>
                                            <span class="text-muted">{{ $appt->patient->phone }}</span>
                                        </div>
                                        <span
                                            class="badge bg-{{ $appt->badgeColor }}-subtle text-{{ $appt->badgeColor }}">
                                            {{ ucfirst($appt->status->label()) }}
                                        </span>
                                    </div>

                                    <ul class="list-unstyled mb-3">
                                        <li class="d-flex align-items-center" style="gap: 0.5rem;">
                                            <i class="fa fa-clock text-muted"></i>
                                            <span>
                                                {{ $appt->appointment_time->format('H:i') }},
                                                {{ $appt->appointment_date->format('d M Y') }}
                                            </span>
                                        </li>
                                        <li class="d-flex align-items-center" style="gap: 0.5rem;">
                                            <i class="fa fa-hospital text-muted"></i>
                                            <span>{{ $appt->clinic?->name }} - {{ $appt->clinic?->location }}</span>
                                        </li>
                                    </ul>
                                    @include('partials.actions')
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="text-center py-5 text-muted w-100">Tidak ada data…</div>
                @endforelse
            </div>
        </div>
        @endforeach

        </div>

        @if ($appointments->hasPages())
            <nav class="d-flex justify-content-center my-4">
                {{ $appointments->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
            </nav>
        @endif


        <script>
            window.filterCards = function(keyword) {
                keyword = keyword.toLowerCase();
                document.querySelectorAll('.appt-card').forEach(el => {
                    el.style.display = el.dataset.name.includes(keyword) ? '' : 'none';
                });
            };
            window.filterClinic = function(clinic) {
                document.querySelectorAll('.appt-card').forEach(el => {
                    el.style.display = !clinic || el.dataset.clinic === clinic ? '' : 'none';
                });
            };
        </script>
    @endsection
