@extends('layouts.app')

@section('content')
    <ul class="container">
        <div class="border-bottom">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <input type="text" class="form-control w-auto" placeholder="Cari tiket...">
                <select class="form-select w-auto">
                    <option>Semua Poliklinik</option>
                    <option>Klinik Anak</option>
                    <option>Klinik Dokter Gigi</option>
                    <option>Klinik Bedah Mulut</option>
                    <option>Klinik Penyakit Dalam</option>
                    <option>Klinik Mata</option>
                    <option>Klinik Jantung</option>
                </select>
            </div>
            <ul class="nav nav-pills gap-2">
                <p class="mb-2 fw-semibold">Status</p>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Akan Datang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Selesai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Dibatalkan</a>
                </li>
            </ul>
        </div>
    </ul>
@endsection
