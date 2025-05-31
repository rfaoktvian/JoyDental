@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
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

        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-users text-muted" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold">{{ $users->total() }}</h4>
                    <small class="text-muted">total pengguna</small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- Filters Button -->
                <button class="btn btn-outline-secondary d-flex align-items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#filtersModal">
                    <i class="fas fa-filter"></i>
                    Filters
                </button>

                <!-- View Toggle -->
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-secondary active">
                        <i class="fas fa-th"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary">
                        <i class="fas fa-list"></i>
                    </button>
                </div>

                <!-- Add User Button -->
                <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#addUserModal">
                    <i class="fas fa-plus"></i>
                    Add User
                </button>
            </div>
        </div>

        <!-- Search and Table Container -->
        <div class="bg-white rounded-3 shadow-sm border">
            <!-- Search Header -->
            <div class="border-bottom p-3">
                <form method="GET" action="{{ route('admin.users') }}" class="d-flex align-items-center">
                    <div class="input-group" style="max-width: 400px;">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0"
                            placeholder="Cari nama, email, atau NIK" name="search" value="{{ request('search') }}">
                    </div>
                </form>
            </div>

            <!-- Table Header -->
            <div class="px-3 py-2 bg-light border-bottom">
                <div class="row align-items-center text-muted small fw-semibold text-uppercase">
                    <div class="col-3">Nama Pengguna</div>
                    <div class="col-2">Telepon</div>
                    <div class="col-2">Email</div>
                    <div class="col-2">Role</div>
                    <div class="col-1">Terdaftar</div>
                    <div class="col-1">Update Terakhir</div>
                    <div class="col-1">Status</div>
                </div>
            </div>

            <!-- Table Body -->
            <div class="table-responsive">
                @forelse ($users as $user)
                    <div class="px-3 py-3 border-bottom user-row" style="cursor: pointer;" data-bs-toggle="modal"
                        data-bs-target="#settingsUserModal-{{ $user->id }}">
                        <div class="row align-items-center">
                            <!-- User Info with Avatar -->
                            <div class="col-3">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3">
                                        @if ($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle"
                                                width="40" height="40" style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                                style="width: 40px; height: 40px; background: {{ collect(['#6366f1', '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'])->random() }};">
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

                            <!-- Phone -->
                            <div class="col-2">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-phone me-2"></i>
                                    <span>{{ $user->phone ?? '-' }}</span>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-2">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-envelope me-2"></i>
                                    <span>{{ $user->email }}</span>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="col-2">
                                <span
                                    class="badge rounded-pill 
                                    {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'doctor' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>

                            <!-- Registered Date -->
                            <div class="col-1">
                                <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                            </div>

                            <!-- Last Update -->
                            <div class="col-1">
                                <small class="text-muted">{{ $user->updated_at->format('d M Y') }}</small>
                            </div>

                            <!-- Status -->
                            <div class="col-1">
                                <span class="badge bg-success rounded-pill">Aktif</span>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Modal -->
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
                                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
                                                        User</option>
                                                    <option value="doctor"
                                                        {{ $user->role == 'doctor' ? 'selected' : '' }}>Doctor</option>
                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                                                        Admin</option>
                                                </select>
                                            </div>
                                        @else
                                            <input type="hidden" name="role" value="{{ $user->role }}">
                                        @endif

                                        <div class="d-flex gap-2 justify-content-end">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Batal</button>
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
                                                <i class="fas fa-trash me-2"></i>
                                                Hapus Akun
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
                            <p class="mb-0">Tidak ada data pengguna</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Footer -->
            @if ($users->hasPages())
                <div class="border-top px-3 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Menampilkan {{ $users->firstItem() }}-{{ $users->lastItem() }} dari {{ $users->total() }}
                            pengguna
                        </small>
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Add User Modal (you can add this separately) -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Pengguna Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your form here -->
                    <p class="text-muted">Form untuk menambah pengguna baru akan ditambahkan di sini.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Modal -->
    <div class="modal fade" id="filtersModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Filter Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your filter options here -->
                    <p class="text-muted">Filter options akan ditambahkan di sini.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .user-row:hover {
            background-color: #f8f9fa;
        }

        .container-fluid {
            max-width: 1400px;
        }

        .btn-group .btn.active {
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .input-group-text {
            background: transparent;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .btn-primary {
            background-color: #6366f1;
            border-color: #6366f1;
        }

        .btn-primary:hover {
            background-color: #5856eb;
            border-color: #5856eb;
        }
    </style>
@endsection
