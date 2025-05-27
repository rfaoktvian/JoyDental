@extends('layouts.app')

@section('content')
    <div class="banner d-flex justify-content-center align-items-center text-center text-white mb-2 rounded py-4 px-3"
        style="background: linear-gradient(135deg, #d32f2f, #f44336);">
        <div style="z-index: 2;">
            <h2 class="fw-bold mb-2">Daftar Poliklinik Kami</h2>
            <p class="mb-0">Poliklinik-poliklinik yang berdedikasi untuk kesehatan Anda.</p>
        </div>
    </div>

    <section class="container py-2 px-0">
        <div class="row g-3">
            @foreach ($polyclinics as $poliklinik)
                <div class="col-md-3 col-sm-6">
                    <div class="custom_card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ asset('images/hospital.svg') }}" alt="Ikon Hospital" width="45"
                                    height="45" class="rounded-circle me-3 bg-danger">
                                <div>
                                    <h6 class="mb-0">{{ $poliklinik->name }}</h6>
                                    <small>{{ $poliklinik->location }}</small><br>
                                    @php
                                        $badge = $poliklinikTypes[$poliklinik->type];
                                    @endphp
                                    <span class="badge {{ $badge['class'] }} mt-1">{{ $badge['label'] }}</span>
                                </div>
                            </div>

                            <p class="mt-2 mb-0">Senin - Jumat | 08:00 - 16:00</p>
                            <p>Kapasitas {{ $poliklinik->capacity }} pasien</p>
                            <a href="#" class="btn btn-danger btn-sm">Buat Janji Temu</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
