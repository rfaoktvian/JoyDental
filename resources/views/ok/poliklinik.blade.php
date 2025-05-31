@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-danger">Manajemen Poliklinik</h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-danger text-white fw-bold">
            Daftar Poliklinik
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Poliklinik</th>
                        <th>Tipe Poliklinik</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $polikliniks = [
                            ['nama' => 'Umum', 'type' => 'General Practice'],
                            ['nama' => 'Anak', 'type' => 'Pediatric'],
                            ['nama' => 'Gigi', 'type' => 'Dental'],
                            ['nama' => 'Jantung', 'type' => 'Cardiology'],
                        ];
                    @endphp

                    @foreach ($polikliniks as $i => $poli)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $poli['nama'] }}</td>
                        <td>{{ $poli['type'] }}</td>
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
                <small class="text-muted">* Data poliklinik ini hanya untuk keperluan manajemen internal.</small>
            </div>
        </div>
    </div>
</div>

@endsection
