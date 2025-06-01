@extends('layouts.app')

@section('content')
    <style>
        .custom_card {
            background-color: #fff;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
        }

        .custom_card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        }
    </style>
    <div class="banner d-flex justify-content-center align-items-center text-center text-white mb-2 rounded py-4 px-3"
        style="background: linear-gradient(135deg, #d32f2f, #f44336);">
        <div style="z-index: 2;">
            <h2 class="fw-bold mb-2">Daftar Poliklinik Kami</h2>
            <p class="mb-0">Poliklinik-poliklinik yang berdedikasi untuk kesehatan Anda.</p>
        </div>
    </div>

    <section class="container">
        <div class="row g-3">
            @foreach ($polyclinics as $poliklinik)
                @php
                    $badge = $poliklinikTypes[$poliklinik->type];
                @endphp
                <div class="col-md-3 col-sm-6">
                    <div class="custom_card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-center align-items-center rounded-circle me-3"
                                    style="width: 45px; height: 45px; background-color: #ffe6e6;">
                                    <i class="fas {{ $badge['icon'] }} text-danger" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $poliklinik->name }}</h6>
                                    <small>{{ $poliklinik->location }}</small><br>
                                    <span class="badge {{ $badge['class'] }} mt-1">{{ $badge['label'] }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center text-muted small mt-2 mb-2">
                                <i class="fas fa-users me-2 text-secondary"></i>
                                <span>Kapasitas <strong>{{ $poliklinik->capacity }}</strong> Orang </span>
                            </div>

                            @guest
                                <a data-bs-toggle="modal" data-bs-target="#loginModal"
                                    class="btn btn-danger btn-sm mt-auto rounded-3 shadow-sm">
                                    Buat Janji Temu
                                </a>
                            @else
                                <a href="#" class="btn btn-danger btn-sm mt-auto rounded-3 shadow-sm">Buat Janji Temu</a>
                            @endguest
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
