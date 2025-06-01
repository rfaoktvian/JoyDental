@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/manager.css') }}">

    <div class="container">
        <div class="mb-3">
            <h4 class="fw-bold text-dark mb-1">Manajemen Poliklinik</h4>
            <p class="text-muted mb-0">
                Kelola data poliklinik, termasuk menambah, mengubah, dan memantau informasi serta aktivitas poliklinik yang
                terdaftar di sistem.
            </p>
        </div>
        <div class="mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-hospital-alt text-muted" style="font-size: 1.5rem; line-height: 1;"></i>
            <span class="fw-bold" style="font-size: 1.5rem;">{{ $polyclinics->total() }}</span>
            <small class="fw-bold fs-5 text-muted">Poliklinik</small>
        </div>

        <div class="mb-4">
            <form method="GET" action="{{ route('admin.users') }}"
                class="row gx-2 gy-2 align-items-center justify-content-end">

                <div class="col-auto d-flex justify-content-end">
                    <a class="btn btn-danger btn-sm" data-modal-url="{{ route('admin.poliklinik.create') }}"
                        data-modal-title="Tambah Poliklinik">
                        <i class="fas fa-plus"></i> Tambah Poliklinik
                    </a>
                </div>

                <div class="col-auto">
                    <a href="{{ request()->fullUrl() }}"
                        class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center p-0"
                        style="width:32px;height:32px" title="Refresh">
                        <i class="fa fa-sync-alt m-auto"></i>
                    </a>
                </div>

                <input type="hidden" name="page" value="{{ request('page') }}">
            </form>
        </div>

        <div class="row g-3" id="cardList">
            @forelse ($polyclinics as $data)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm bg-white border border-1 border-mute">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3">
                                        <div class="rounded-circle 
                                                           d-flex align-items-center justify-content-center 
                                                           text-white fw-bold"
                                            style="width: 40px; height: 40px; 
                                                           background: {{ collect(['#6366f1', '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'])->random() }};">
                                            @php
                                                $words = explode(' ', trim($data->name));
                                                $initials = '';
                                                $maxWords = min(3, count($words));
                                                for ($i = 0; $i < $maxWords; $i++) {
                                                    $initials .= mb_substr($words[$i], 0, 1);
                                                }
                                                $initials = strtoupper($initials);
                                            @endphp
                                            {{ $initials }}
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $data->name }}</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt text-muted" style="width: 16px;"></i>
                                    <span class="small text-muted ms-2">
                                        {{ $data->location ?? '-' }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-users text-muted" style="width: 16px;"></i>
                                    <span class="small text-muted ms-2">
                                        Kapasitas: {{ $data->capacity }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar-alt text-muted" style="width: 16px;"></i>
                                    <span class="small text-muted ms-2">
                                        Terdaftar: {{ $data->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-sync-alt text-muted" style="width: 16px;"></i>
                                    <span class="small text-muted ms-2">
                                        Update: {{ $data->updated_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-sm btn-outline-secondary"
                                    data-modal-url="{{ route('admin.poliklinik.edit', ['id' => $data->id]) }}"
                                    data-modal-title="Ubah Data Poliklinik" style="width: 36px; height: 36px; padding: 0;">
                                    <i class="fas fa-cog fs-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
                        <p class="mb-0">Tidak ada data Poliklinik</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($polyclinics->hasPages())
            <nav class="d-flex justify-content-center my-4 pagination-wrapper">
                {{ $polyclinics->appends(request()->all())->links('vendor.pagination.bootstrap-5') }}
            </nav>
        @endif
    </div>

    @include('partials.modal-loader')
@endsection

{{-- <p>@json($polyclinics)</p> --}}
