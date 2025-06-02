@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="fw-bold text-dark mb-3">Profil Pengguna</h4>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="custom_card shadow-sm bg-white border border-1 border-mute">
                    <div class="card-body text-center position-relative">
                        <button class="btn btn-sm btn-outline-primary position-absolute top-0 end-0 m-2"
                            data-modal-url="/doctor/{{ $doctor->id ?? 0 }}/edit" data-modal-title="Edit Profil Dokter">
                            <i class="fas fa-edit"></i>
                        </button>
                        <div class="position-relative">
                            <img src="{{ asset('images/doctors_login.png') }}" alt="Profile Photo"
                                class="rounded-circle shadow-sm border border-3 border-light mb-2"
                                style="width: 120px; height: 120px; object-fit: cover;" id="profilePhoto">
                        </div>

                        <h5 class="fw-bold">{{ $user->name }}</h5>
                        <p class="text-muted mb-1">{{ ucfirst($user->role) }}</p>
                        <p class="small text-muted mb-0">{{ $user->email }}</p>
                        <p class="small text-muted">{{ $user->phone ?? '-' }}</p>
                    </div>
                </div>

            </div>

            <div class="col-md-8 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white fw-semibold">
                        Informasi Pribadi
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted mb-0">NIK</label>
                                <div class="fw-semibold">{{ $user->nik }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted mb-0">Nama Lengkap</label>
                                <div class="fw-semibold">{{ $user->name }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted mb-0">Jenis Kelamin</label>
                                <div class="fw-semibold">
                                    @if ($user->gender === 'man')
                                        Laki-laki
                                    @elseif ($user->gender === 'woman')
                                        Perempuan
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted mb-0">Tanggal Lahir</label>
                                <div class="fw-semibold">
                                    {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->translatedFormat('d F Y') : '-' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted mb-0">Alamat</label>
                                <div class="fw-semibold">{{ $user->address ?? '-' }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted mb-0">Pekerjaan</label>
                                <div class="fw-semibold">{{ $user->occupation ?? '-' }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted mb-0">Email</label>
                                <div class="fw-semibold">{{ $user->email }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted mb-0">No. HP</label>
                                <div class="fw-semibold">{{ $user->phone ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Optional: Add Appointments or Reviews section below --}}
    </div>
@endsection
