@extends('layouts.app')

@section('content')
    <div class="banner">
        <h4 class="mb-4 fw-bold">Manajemen Akun</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form method="GET" action="{{ route('admin.users') }}" class="input-group w-25">
                        <input type="text" class="form-control" placeholder="Cari nama, email, atau NIK" name="search"
                            value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus"></i> Tambah Akun
                    </button>
                </div>

                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIK</th>
                            <th>Role</th>
                            <th>Tanggal Dibuat</th>
                            <th style="width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->nik }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'doctor' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                        data-bs-target="#settingsUserModal-{{ $user->id }}">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Settings Modal -->
                            <div class="modal fade" id="settingsUserModal-{{ $user->id }}" tabindex="-1">
                                <div class="modal-dialog modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Pengaturan Akun</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label>Nama</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ $user->name }}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ $user->email }}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Role</label>
                                                <select class="form-select" name="role">
                                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
                                                        User</option>
                                                    <option value="doctor" {{ $user->role == 'doctor' ? 'selected' : '' }}>
                                                        Doctor</option>
                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                                                        Admin</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Simpan</button>
                                        </form>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger"
                                                onclick="return confirm('Hapus akun ini?')">
                                                Hapus Akun
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
            </div>
        @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data pengguna</td>
            </tr>
            @endforelse
            </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addUserModal" tabindex="1">
        <div class="modal-dialog">
            <form action="{{ route('admin.users.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label>NIK</label>
                        <input type="text" class="form-control" name="nik" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select class="form-select" name="role">
                            <option value="user">User</option>
                            <option value="doctor">Doctor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Tambah</button>
                </div>
            </form>
        </div>
    </div>
@endsection
