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
            color: #6B2C91;
        }

        .nav-pills .nav-link.active {
            color: #fff;
            background-color: #6B2C91;
            border: 1px solid #6B2C91;
        }

        .page-item .page-link {
            color: #6B2C91;
            border-radius: 0;
            min-width: 40px;
            text-align: center;
        }

        .page-item.active .page-link {
            background-color: #6B2C91;
            color: white;
            border-color: #6B2C91;
        }

        .pagination-wrapper .page-link {
            padding: .35rem .65rem;
            font-size: .825rem;
        }

        .pagination-wrapper .page-link i {
            font-size: .65rem;
            vertical-align: -1px;
        }

        .bg-danger {
            --bs-bg-opacity: 1;
            background-color: #9868b0 !important;
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
        @if(request('payment') == 'success')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Pembayaran Berhasil!</strong> Booking Anda telah dikonfirmasi. 
                Silakan datang sesuai jadwal yang telah ditentukan.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif(request('payment') == 'pending')
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-clock me-2"></i>
                <strong>Pembayaran Pending!</strong> 
                @if(request('method') == 'bank_transfer')
                    Silakan selesaikan transfer bank Anda. Status akan diperbarui otomatis setelah pembayaran diterima.
                @elseif(request('method') == 'gopay' || request('method') == 'shopeepay')
                    Silakan selesaikan pembayaran melalui aplikasi E-Wallet Anda.
                @else
                    Silakan selesaikan pembayaran Anda sesuai instruksi yang diberikan.
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="tab-content" id="ongoingTabs">
            <div class="tab-pane fade show active" id="pane-upcoming" role="tabpanel">
                <ul class="nav nav-pills small fw-bold align-items-center justify-content-between mb-2" id="statusTabs"
                    style="gap:.5rem">
                    <h5 class="fw-semibold d-flex align-items-center mb-0">
                        Tiket Antrian
                    </h5>
                    <div class="d-flex align-items-center gap-2 ms-auto mb-0">
                        <button id="refreshBtn"
                            class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center"
                            style="width:32px;height:32px" onclick="window.location.reload();" title="Refresh">
                            <i class="fa fa-sync-alt"></i>
                        </button>
                        <a href="{{ route('janji-temu') }}" class="btn btn-danger d-flex align-items-center gap-1 px-3"
                            style="height: 32px">
                            <p class="mb-0">Buat Janji Temu</p>
                        </a>
                    </div>
                </ul>

                <div class="row g-4">
                    @forelse ($ongoing as $appt)
                        @include('partials.ongoing_ticket-card', ['appt' => $appt])
                    @empty
                        <div class="text-center py-5 text-muted w-100">Tidak ada tiket…</div>
                    @endforelse
                </div>

                @if ($ongoing->hasPages())
                    <nav class="d-flex justify-content-center">
                        {{ $ongoing->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                    </nav>
                @endif
            </div>
        </div>


        <div class="tab-content" id="historyTabs">
            <div class="border-bottom mb-3 pb-2 sticky-top pt-3 px-1" style="background: #F5F5F5;">
                <form method="GET" action="{{ url()->current() }}" class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <input type="text" name="q" value="{{ $search }}"
                        class="form-control form-control-sm w-auto" placeholder="Cari pasien…">
                    <select name="clinic" class="form-select form-select-sm w-auto">
                        <option value="">Semua Poliklinik</option>
                        @foreach ($appointments->pluck('clinic.name')->unique() as $clinicName)
                            <option value="{{ $clinicName }}" {{ $clinicName == $clinic ? 'selected' : '' }}>
                                {{ $clinicName }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button>
                </form>

                <ul class="nav nav-pills small fw-bold align-items-center" id="statusTabs" style="gap:.5rem">
                    <span class="fw-semibold fs-6">Status</span>
                    @foreach ($tabs as $key => $t)
                        <li class="nav-item">
                            <a href="{{ request()->fullUrlWithQuery(['tab' => $key, 'page' => 1]) }}"
                                class="nav-link {{ $key === $currentTab ? 'active' : '' }} fs-6">
                                {{ $t['label'] }}
                                <span class="badge bg-danger border border-1 border-white ms-1">{{ $t['count'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @foreach ($tabs as $key => $tab)
                @if ($key === $currentTab)
                    <div class="tab-pane fade show active pt-2" id="pane-{{ $key }}" role="tabpanel">
                        <div class="row g-4" id="grid-{{ $key }}">
                            @forelse ($appointments->when($key!=='all',fn($q) => $q->where('status',
                            App\Enums\AppointmentStatus::fromLabel($key))) as $appt)
                            @include('partials.ticket-card', ['appt' => $appt])
                        @empty
                            <div class="text-center py-5 text-muted w-100">Tidak ada data…</div>
                @endforelse
        </div>
    </div>
    @endif
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


    @include('partials.modal-loader')
@endsection
