@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-danger">Manajemen Dokter</h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-danger text-white fw-bold">
            Daftar Dokter
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Dokter</th>
                        <th>Spesialisasi</th>
                        <th>Email</th>
                        <th>No. Handphone</th>
                        <th>Nomor STR</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $dokters = [
                            [
                                'nama' => 'dr. Budi Santoso',
                                'spesialis' => 'Umum',
                                'email' => 'budi.santoso@rs.com',
                                'telepon' => '081234567890',
                                'str' => '1234567890'
                            ],
                            [
                                'nama' => 'dr. Rina Aprilia',
                                'spesialis' => 'Anak',
                                'email' => 'rina.aprilia@rs.com',
                                'telepon' => '082345678901',
                                'str' => '2345678901'
                            ],
                            [
                                'nama' => 'dr. Ahmad Zulfikar',
                                'spesialis' => 'Gigi',
                                'email' => 'ahmad.zulfikar@rs.com',
                                'telepon' => '083456789012',
                                'str' => '3456789012'
                            ]
                        ];
                    @endphp

                    @foreach ($dokters as $i => $dokter)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $dokter['nama'] }}</td>
                        <td>{{ $dokter['spesialis'] }}</td>
                        <td>
                            <a href="mailto:{{ $dokter['email'] }}" class="text-decoration-none">
                                <i class="fas fa-envelope text-primary"></i> {{ $dokter['email'] }}
                            </a>
                        </td>
                        <td>
                            <a href="tel:{{ $dokter['telepon'] }}" class="text-decoration-none">
                                <i class="fas fa-phone text-success"></i> {{ $dokter['telepon'] }}
                            </a>
                        </td>
                        <td>{{ $dokter['str'] }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                <small class="text-muted">* Data dokter hanya dapat dimodifikasi oleh administrator sistem.</small>
            </div>
        </div>
    </div>
</div>

@endsection
