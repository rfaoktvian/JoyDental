@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/manager.css') }}">

    <div class="container">

        <div class="mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-user-md text-muted" style="font-size: 1.5rem; line-height: 1;"></i>
            <span class="fw-bold" style="font-size: 1.5rem;">{{ $doctors->total() }}</span>
            <small class="text-secondary">Dokter</small>
        </div>

        <div class="mb-4">
            <form method="GET" action="{{ route('admin.users') }}" class="row gx-2 gy-2 align-items-center">
                <div class="col-auto flex-grow-1">
                    <div class="input-group input-group-sm bg-white">
                        <span class="input-group-text bg-transparent">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 bg-white" name="search"
                            placeholder="Cari pengguna..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-auto">
                    <select name="sort_by" class="form-select form-select-sm">
                        <option value="">Urutkan Berdasarkan</option>
                        <option value="role" {{ request('sort_by') === 'role' ? 'selected' : '' }}>Role</option>
                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Tanggal
                            Dibuat</option>
                        <option value="updated_at" {{ request('sort_by') === 'updated_at' ? 'selected' : '' }}>Update
                            Terakhir</option>
                    </select>
                </div>

                <div class="col-auto">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Urutan">
                        <button type="submit" name="sort_order" value="asc"
                            class="btn bg-white {{ request('sort_order') === 'asc' ? 'text-danger active' : 'text-secondary border-1 border-muted border' }}">
                            <i class="fas fa-arrow-up"></i>
                        </button>
                        <button type="submit" name="sort_order" value="desc"
                            class="btn bg-white {{ request('sort_order') === 'desc' ? 'text-danger active' : 'text-secondary border-1 border-muted border' }}">
                            <i class="fas fa-arrow-down"></i>
                        </button>
                    </div>
                </div>

                <div class="col-auto">
                    <a class="btn btn-danger btn-sm" data-modal-url="{{ route('admin.dokter.create') }}"
                        data-modal-title="Tambah Dokter">
                        <i class="fas fa-plus"></i> Tambah Dokter
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
            @forelse ($doctors as $doctor)
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
                                                $words = explode(' ', trim($doctor->name));
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
                                        <h6 class="mb-0 fw-bold">{{ $doctor->name }}</h6>
                                        <small class="text-muted d-block">{{ $doctor->specialization }}</small>
                                        <small class="text-muted d-block">{{ $doctor->nik }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-envelope text-muted" style="width:16px;"></i>
                                    <span class="small text-muted ms-2">{{ $doctor->user->email ?? '-' }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-phone text-muted" style="width:16px;"></i>
                                    <span class="small text-muted ms-2">{{ $doctor->user->phone ?? '-' }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt text-muted" style="width:16px;"></i>
                                    <span class="small text-muted ms-2">{{ $doctor->user->address ?? '-' }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar-alt text-muted" style="width:16px;"></i>
                                    <span class="small text-muted ms-2">Terdaftar:
                                        {{ $doctor->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-sync-alt text-muted" style="width:16px;"></i>
                                    <span class="small text-muted ms-2">Update:
                                        {{ $doctor->updated_at->format('d M Y') }}</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-sm btn-outline-secondary"
                                    data-modal-url="{{ route('admin.dokter.edit', ['id' => $doctor->id]) }}"
                                    data-modal-title="Ubah Data Dokter" style="width: 36px; height: 36px; padding: 0;">
                                    <i class="fas fa-cog"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-user-md fa-3x mb-3 opacity-25"></i>
                        <p class="mb-0">Tidak ada data Dokter</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($doctors->hasPages())
            <nav class="d-flex justify-content-center my-4 pagination-wrapper">
                {{ $doctors->appends(request()->all())->links('vendor.pagination.bootstrap-5') }}
            </nav>
        @endif
    </div>

    @include('partials.modal-loader')
@endsection
