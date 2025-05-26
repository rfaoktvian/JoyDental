@extends('layouts.app')

@section('content')
    <div class="banner d-flex justify-content-center align-items-center text-center text-white mb-2 rounded py-4 px-3"
        style="background: linear-gradient(135deg, #d32f2f, #f44336);">
        <div style="z-index: 2;">
            <h2 class="fw-bold mb-2">Daftar Dokter Kami</h2>
            <p class="mb-0">Tim medis profesional dan berdedikasi untuk kesehatan Anda.</p>
        </div>
    </div>

    <section class="container py-2 px-0">
        <div class="row g-3">
            @php
                $doctors = [
                    [
                        'name' => 'dr. Amanda Putri, Sp.A',
                        'specialty' => 'Dokter Spesialis Anak',
                        'description' =>
                            'Berpengalaman lebih dari 8 tahun di klinik tumbuh kembang anak. Klinik Anak - Gedung Cokro Lt.3.',
                        'image' => 'doctors_login.png',
                    ],
                    [
                        'name' => 'drg. Bima Raharja, Sp.BM',
                        'specialty' => 'Bedah Mulut Maksilofasial',
                        'description' =>
                            'Menangani berbagai kasus bedah mulut kompleks. Praktik di Klinik Bedah - Gedung Cokro Lt.3.',
                        'image' => 'doctors_login.png',
                    ],
                    [
                        'name' => 'drg. Citra Ayu',
                        'specialty' => 'Dokter Gigi Umum',
                        'description' =>
                            'Melayani konsultasi dan perawatan gigi umum. Praktik di Klinik Gigi - Gedung Cokro Lt.4.',
                        'image' => 'doctors_login.png',
                    ],
                    [
                        'name' => 'drg. Citra Ayu',
                        'specialty' => 'Dokter Gigi Umum',
                        'description' =>
                            'Melayani konsultasi dan perawatan gigi umum. Praktik di Klinik Gigi - Gedung Cokro Lt.4.',
                        'image' => 'doctors_login.png',
                    ],
                    [
                        'name' => 'drg. Citra Ayu',
                        'specialty' => 'Dokter Gigi Umum',
                        'description' =>
                            'Melayani konsultasi dan perawatan gigi umum. Praktik di Klinik Gigi - Gedung Cokro Lt.4.',
                        'image' => 'doctors_login.png',
                    ],
                    [
                        'name' => 'drg. Citra Ayu',
                        'specialty' => 'Dokter Gigi Umum',
                        'description' =>
                            'Melayani konsultasi dan perawatan gigi umum. Praktik di Klinik Gigi - Gedung Cokro Lt.4.',
                        'image' => 'doctors_login.png',
                    ],
                    [
                        'name' => 'drg. Citra Ayu',
                        'specialty' => 'Dokter Gigi Umum',
                        'description' =>
                            'Melayani konsultasi dan perawatan gigi umum. Praktik di Klinik Gigi - Gedung Cokro Lt.4.',
                        'image' => 'doctors_login.png',
                    ],
                    [
                        'name' => 'drg. Citra Ayu',
                        'specialty' => 'Dokter Gigi Umum',
                        'description' =>
                            'Melayani konsultasi dan perawatan gigi umum. Praktik di Klinik Gigi - Gedung Cokro Lt.4.',
                        'image' => 'doctors_login.png',
                    ],
                    [
                        'name' => 'drg. Citra Ayu',
                        'specialty' => 'Dokter Gigi Umum',
                        'description' =>
                            'Melayani konsultasi dan perawatan gigi umum. Praktik di Klinik Gigi - Gedung Cokro Lt.4.',
                        'image' => 'doctors_login.png',
                    ],
                    [
                        'name' => 'drg. Citra Ayu',
                        'specialty' => 'Dokter Gigi Umum',
                        'description' =>
                            'Melayani konsultasi dan perawatan gigi umum. Praktik di Klinik Gigi - Gedung Cokro Lt.4.',
                        'image' => 'doctors_login.png',
                    ],
                    [
                        'name' => 'drg. Citra Ayu',
                        'specialty' => 'Dokter Gigi Umum',
                        'description' =>
                            'Melayani konsultasi dan perawatan gigi umum. Praktik di Klinik Gigi - Gedung Cokro Lt.4.',
                        'image' => 'doctors_login.png',
                    ],
                    [
                        'name' => 'drg. Citra Ayu',
                        'specialty' => 'Dokter Gigi Umum',
                        'description' =>
                            'Melayani konsultasi dan perawatan gigi umum. Praktik di Klinik Gigi - Gedung Cokro Lt.4.',
                        'image' => 'doctors_login.png',
                    ],
                    [
                        'name' => 'drg. Citra Ayu',
                        'specialty' => 'Dokter Gigi Umum',
                        'description' =>
                            'Melayani konsultasi dan perawatan gigi umum. Praktik di Klinik Gigi - Gedung Cokro Lt.4.',
                        'image' => 'doctors_login.png',
                    ],
                    [
                        'name' => 'drg. Citra Ayu',
                        'specialty' => 'Dokter Gigi Umum',
                        'description' =>
                            'Melayani konsultasi dan perawatan gigi umum. Praktik di Klinik Gigi - Gedung Cokro Lt.4.',
                        'image' => 'doctors_login.png',
                    ],
                ];
            @endphp

            @foreach ($doctors as $doctor)
                <div class="col-md-4 col-sm-6">
                    <div class="card shadow-sm border-0 h-100">
                        <img src="{{ asset('images/doctors_dashboard.png') }}" class="card-img-top" alt="{{ $doctor['name'] }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1 fw-bold">{{ $doctor['name'] }}</h5>
                            <small class="text-muted">{{ $doctor['specialty'] }}</small>
                            <p class="mt-2 mb-0">{{ $doctor['description'] }}</p>
                            <a href="janji_temu.html" class="btn btn-outline-danger btn-sm mt-3">Buat Janji Temu</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection