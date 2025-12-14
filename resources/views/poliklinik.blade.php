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

    .btn-danger {
        background-color: #6B2C91 !important;
        border-color: #6B2C91 !important;
    }

    .btn-danger:hover {
        background-color: #4F206B !important;
        border-color: #6B2C91 !important;
    }
</style>

@php
$serviceBadges = [
    'Scaling' => ['label' => 'General Dentistry', 'class' => 'bg-info'],
    'Tambal Gigi' => ['label' => 'Conservative Dentistry', 'class' => 'bg-primary'],
    'Tambal Estetik' => ['label' => 'Esthetic Dentistry', 'class' => 'bg-success'],
    'Cabut Gigi' => ['label' => 'Oral Surgery', 'class' => 'bg-danger'],
    'Behel' => ['label' => 'Orthodontics', 'class' => 'bg-warning'],
    'Bleaching' => ['label' => 'Esthetic Dentistry', 'class' => 'bg-secondary'],
    'Veneer' => ['label' => 'Esthetic Dentistry', 'class' => 'bg-dark'],
    'Perawatan Saluran Akar' => ['label' => 'Endodontics', 'class' => 'bg-dark'],
    'Gigi Tiruan' => ['label' => 'Prosthodontics', 'class' => 'bg-secondary'],
    'Konsultasi Gigi' => ['label' => 'General Dentistry', 'class' => 'bg-light text-dark'],
];
@endphp

<div class="banner d-flex justify-content-center align-items-center text-center text-white mb-3 rounded py-4 px-3"
    style="background: linear-gradient(135deg, #6B2C91, #7f4ea7);">
    <div>
        <h2 class="fw-bold mb-2">
            <i class="fas fa-tooth me-2"></i>
            Layanan Klinik Gigi JoyDental
        </h2>
        <p class="mb-0">
            Perawatan gigi terbaik dengan dokter spesialis berpengalaman.
        </p>
    </div>
</div>

<section class="container">
    <div class="row g-3">
        @foreach ($polyclinics as $poliklinik)
            @php
                $badge = $serviceBadges[$poliklinik->name]
                    ?? ['label' => 'Layanan Gigi', 'class' => 'bg-secondary'];
            @endphp

            <div class="col-md-3 col-sm-6">
                <div class="custom_card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <div class="d-flex justify-content-center align-items-center rounded-circle me-3"
                                style="width: 45px; height: 45px; background-color: #ffe6ff;">
                                <i class="fas fa-tooth text-danger" style="font-size: 1.4rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $poliklinik->name }}</h6>
                                <small class="text-muted">{{ $poliklinik->location }}</small><br>
                                <span class="badge {{ $badge['class'] }} mt-1">
                                    {{ $badge['label'] }}
                                </span>
                            </div>
                        </div>

                        <div class="text-muted small mb-3">
                            <i class="fas fa-users me-1"></i>
                            Kapasitas <strong>{{ $poliklinik->capacity }}</strong> Orang
                        </div>

                        @guest
                            <a data-bs-toggle="modal"
                               data-bs-target="#loginModal"
                               class="btn btn-danger btn-sm mt-auto rounded-3 shadow-sm">
                                Buat Janji Temu
                            </a>
                        @else
                            <a href="{{ route('janji-temu') }}"
                               class="btn btn-danger btn-sm mt-auto rounded-3 shadow-sm">
                                Buat Janji Temu
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
