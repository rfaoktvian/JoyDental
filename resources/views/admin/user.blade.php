@extends('layouts.app')

@section('content')
    <style>
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

        /* Style untuk ikon View Toggle */
        .view-toggle .btn {
            border: 1px solid #ced4da;
            color: #6c757d;
            background-color: #fff;
        }

        .view-toggle .btn.active {
            color: #d32f2f;
            border-color: #d32f2f;
        }

        /* Hover effect untuk baris di table view */
        .user-row:hover {
            background-color: #f8f9fa;
        }

        /* Fokus styling untuk form-control */
        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }
    </style>

    <div class="container">

        <div id="notification">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <div class="mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-users text-muted" style="font-size: 1.5rem; line-height: 1;"></i>
            <span class="fw-bold" style="font-size: 1.5rem;">{{ $users->total() }}</span>
            <small class="text-secondary">Pengguna</small>
        </div>

        <div class="mb-4">
            <form method="GET" action="{{ route('admin.users') }}" class="row gx-2 gy-2 align-items-center"
                hx-get="{{ route('admin.users') }}" hx-target="#page-content" hx-push-url="true"
                hx-trigger="change delay:300ms from:input, change from:select, submit">
                <div class="col-auto flex-grow-1">
                    <div class="input-group input-group-sm bg-white">
                        <span class="input-group-text bg-transparent">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 bg-white" name="search"
                            placeholder="Cari pengguna..." value="{{ request('search') }}"
                            hx-trigger="keyup changed delay:300ms">
                    </div>
                </div>

                <div class="col-auto">
                    @php
                        $selectedRoles = request('filter_role', []);
                        if (!is_array($selectedRoles)) {
                            $selectedRoles = [$selectedRoles];
                        }
                    @endphp
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="filter_role[]" id="filter_admin"
                            value="admin" {{ in_array('admin', $selectedRoles) ? 'checked' : '' }}
                            hx-trigger="click changed">
                        <label class="form-check-label" for="filter_admin">Admin</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="filter_role[]" id="filter_doctor"
                            value="doctor" {{ in_array('doctor', $selectedRoles) ? 'checked' : '' }}
                            hx-trigger="click changed">
                        <label class="form-check-label" for="filter_doctor">Doctor</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="filter_role[]" id="filter_user" value="user"
                            {{ in_array('user', $selectedRoles) ? 'checked' : '' }} hx-trigger="click changed">
                        <label class="form-check-label" for="filter_user">User</label>
                    </div>
                </div>

                <div class="col-auto">
                    <select name="sort_by" class="form-select form-select-sm">
                        <option value="">Urutkan Berdasarkan</option>
                        <option value="role" {{ request('sort_by') === 'role' ? 'selected' : '' }}>
                            Role
                        </option>
                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>
                            Tanggal Dibuat
                        </option>
                        <option value="updated_at" {{ request('sort_by') === 'updated_at' ? 'selected' : '' }}>
                            Update Terakhir
                        </option>
                    </select>
                </div>

                <div class="col-auto">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Urutan">
                        <button type="button" name="sort_order" value="asc"
                            class="btn bg-white {{ request('sort_order') === 'asc' ? 'text-danger active' : 'text-secondary border-1 border-muted border' }}"
                            hx-get="{{ request()->fullUrlWithQuery(['sort_order' => 'asc']) }}" hx-target="#page-content"
                            hx-push-url="true">
                            <i class="fas fa-arrow-up"></i>
                        </button>
                        <button type="button" name="sort_order" value="desc"
                            class="btn bg-white {{ request('sort_order') === 'desc' ? 'text-danger active' : 'text-secondary border-1 border-muted border' }}"
                            hx-get="{{ request()->fullUrlWithQuery(['sort_order' => 'desc']) }}" hx-target="#page-content"
                            hx-push-url="true">
                            <i class="fas fa-arrow-down"></i>
                        </button>
                    </div>
                </div>

                <div class="col-auto view-toggle">
                    <div class="btn-group btn-group-sm" role="group" aria-label="View mode toggle">
                        <button type="button" name="view" value="cards"
                            class="btn {{ request('view', 'cards') === 'cards' ? 'active btn-danger' : 'btn-outline-secondary' }}"
                            hx-get="{{ request()->fullUrlWithQuery(['view' => 'cards']) }}" hx-target="#page-content"
                            hx-push-url="true">
                            <i class="fas fa-th-large" style="font-size: 1rem;"></i>
                        </button>

                        <button type="button" name="view" value="table"
                            class="btn {{ request('view') === 'table' ? 'active btn-danger' : 'btn-outline-secondary' }}"
                            hx-get="{{ request()->fullUrlWithQuery(['view' => 'table']) }}" hx-target="#page-content"
                            hx-push-url="true">
                            <i class="fas fa-list" style="font-size: 1rem;"></i>
                        </button>
                    </div>
                </div>

                <div class="col-auto">
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal"
                        type="button">
                        <i class="fas fa-plus"></i> Tambah Akun
                    </button>
                </div>

                <div class="col-auto">
                    <button id="refreshBtn"
                        class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center p-0"
                        style="width:32px;height:32px" hx-get="{{ request()->fullUrl() }}" hx-target="#page-content"
                        hx-swap="outerHTML" hx-indicator="#htmx-indicator" title="Refresh">
                        <i class="fa fa-sync-alt m-auto"></i>
                    </button>
                </div>

                <input type="hidden" name="page" value="{{ request('page') }}">
            </form>
        </div>


        @if (request('view', 'cards') === 'cards')
            <div class="row g-3" id="cardList">
                @forelse ($users as $user)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm bg-white border border-1 border-mute">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative me-3">
                                            @if ($user->avatar)
                                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                                    class="rounded-circle" width="40" height="40"
                                                    style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle 
                                                           d-flex align-items-center justify-content-center 
                                                           text-white fw-bold"
                                                    style="width: 40px; height: 40px; 
                                                           background: {{ collect(['#6366f1', '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'])->random() }};">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                    <span
                                        class="badge 
                                        {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'doctor' ? 'bg-warning text-dark' : 'bg-secondary') }} text-uppercase">
                                        {{ $user->role }}
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2" style="gap: .5rem;">
                                        <i class="fas fa-id-card text-muted" style="width: 16px;"></i>
                                        <span class="small text-muted">NIK: {{ $user->nik }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2" style="gap: .5rem;">
                                        <i class="fas fa-phone text-muted" style="width: 16px;"></i>
                                        <span class="small text-muted">
                                            {{ $user->phone ?? 'Tidak ada telepon' }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2" style="gap: .5rem;">
                                        <i class="fas fa-calendar text-muted" style="width: 16px;"></i>
                                        <span class="small text-muted">
                                            Terdaftar: {{ $user->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center" style="gap: .5rem;">
                                        <i class="fas fa-clock text-muted" style="width: 16px;"></i>
                                        <span class="small text-muted">
                                            Update: {{ $user->updated_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end" style="margin-left: auto; margin-right: auto;">
                                    <button class="btn btn-sm btn-outline-secondary"
                                        hx-get="{{ route('admin.users.edit', ['id' => $user->id]) }}"
                                        hx-target="#modalBody" hx-swap="innerHTML" hx-trigger="click"
                                        hx-on="htmx:afterOnLoad: (() => {const modalTitle = document.getElementById('modalTitle'); if(modalTitle){modalTitle.outerHTML = '<h5 class=&quot;modal-title fw-bold&quot; id=&quot;modalTitle&quot;>Pengaturan Akun</h5>';}})()"
                                        data-bs-toggle="modal" data-bs-target="#commonModal"
                                        style="width: 36px; height: 36px; padding: 0;">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="settingsUserModal-{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title fw-bold">Pengaturan Akun</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $user->name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ $user->email }}">
                                        </div>
                                        @if ($user->id !== auth()->id())
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Role</label>
                                                <select class="form-select" name="role">
                                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>
                                                        User
                                                    </option>
                                                    <option value="doctor"
                                                        {{ $user->role === 'doctor' ? 'selected' : '' }}>
                                                        Doctor
                                                    </option>
                                                    <option value="admin"
                                                        {{ $user->role === 'admin' ? 'selected' : '' }}>
                                                        Admin
                                                    </option>
                                                </select>
                                            </div>
                                        @else
                                            <input type="hidden" name="role" value="{{ $user->role }}">
                                        @endif

                                        <div class="d-flex gap-2 justify-content-end">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                Batal
                                            </button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>

                                    @if ($user->id !== auth()->id())
                                        <hr class="my-3">
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger w-100"
                                                onclick="return confirm('Hapus akun ini?')">
                                                <i class="fas fa-trash me-2"></i> Hapus Akun
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
                            <p class="mb-0">Tidak ada data pengguna</p>
                        </div>
                    </div>
                @endforelse
            </div>
        @else
            <div class="custom_card" id="tableList">
                <div class="px-3 py-2 bg-light border-bottom">
                    <div class="row align-items-center text-muted small fw-semibold text-uppercase">
                        <div class="col-3">Nama</div>
                        <div class="col-1">Role</div>
                        <div class="col-2">Email</div>
                        <div class="col-2">Telepon</div>
                        <div class="col-2">Tanggal Dibuat</div>
                        <div class="col-1">Update Terakhir</div>
                        <div class="col-1 text-end">Aksi</div>
                    </div>
                </div>

                <div class="table-responsive">
                    @forelse ($users as $user)
                        <div class="px-3 py-3 border-bottom user-row">
                            <div class="row align-items-center">
                                <div class="col-3">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative me-3">
                                            @if ($user->avatar)
                                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                                    class="rounded-circle" width="40" height="40"
                                                    style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                                    style="width: 40px; height: 40px;
                                               background: {{ collect(['#6366f1', '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'])->random() }};">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                            <small class="text-muted">NIK: {{ $user->nik }}</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-1">
                                    <span
                                        class="badge
                            {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'doctor' ? 'bg-warning text-dark' : 'bg-secondary') }}
                            text-uppercase">
                                        {{ $user->role }}
                                    </span>
                                </div>

                                <div class="col-2">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="fas fa-envelope me-2"></i>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="fas fa-phone me-2"></i>
                                        <span>{{ $user->phone ?? '-' }}</span>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="fas fa-calendar me-2"></i>
                                        <span>{{ $user->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>

                                <div class="col-1">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="fas fa-clock me-2"></i>
                                        <span>{{ $user->updated_at->format('d M Y') }}</span>
                                    </div>
                                </div>

                                <div class="col-1 text-end">
                                    <button class="btn btn-sm btn-outline-secondary"
                                        hx-get="{{ route('admin.users.edit', ['id' => $user->id]) }}"
                                        hx-target="#modalBody" hx-swap="innerHTML" hx-trigger="click"
                                        hx-on="htmx:afterOnLoad: (() => {const modalTitle = document.getElementById('modalTitle'); if(modalTitle){modalTitle.outerHTML = '<h5 class=&quot;modal-title fw-bold&quot; id=&quot;modalTitle&quot;>Pengaturan Akun</h5>';}})()"
                                        data-bs-toggle="modal" data-bs-target="#commonModal">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="settingsUserModal-{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-bottom-0">
                                        <h5 class="modal-title fw-bold">Pengaturan Akun</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nama</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ $user->name }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Email</label>
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ $user->email }}">
                                            </div>
                                            @if ($user->id !== auth()->id())
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Role</label>
                                                    <select class="form-select" name="role">
                                                        <option value="user"
                                                            {{ $user->role === 'user' ? 'selected' : '' }}>
                                                            User
                                                        </option>
                                                        <option value="doctor"
                                                            {{ $user->role === 'doctor' ? 'selected' : '' }}>
                                                            Doctor
                                                        </option>
                                                        <option value="admin"
                                                            {{ $user->role === 'admin' ? 'selected' : '' }}>
                                                            Admin
                                                        </option>
                                                    </select>
                                                </div>
                                            @else
                                                <input type="hidden" name="role" value="{{ $user->role }}">
                                            @endif

                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>

                                        @if ($user->id !== auth()->id())
                                            <hr class="my-3">
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger w-100"
                                                    onclick="return confirm('Hapus akun ini?')">
                                                    <i class="fas fa-trash me-2"></i> Hapus Akun
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
                                <p class="mb-0">Tidak ada data pengguna</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        @if ($users->hasPages())
            <nav class="d-flex justify-content-center my-4 pagination-wrapper">
                {{ $users->appends(request()->all())->links('vendor.pagination.bootstrap-5') }}
            </nav>
        @endif

    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Pengguna Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Form untuk menambah pengguna baru ditambahkan di sini.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
