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
            @php
                $polikliniks = [
                    [
                        'name' => 'Klinik Anak',
                        'type' => 1,
                        'room' => 'Gedung Cokro Aminoto Lt.3',
                        'date_from' => 'Senin',
                        'date_to' => 'Rabu',
                        'time_from' => '13:00',
                        'time_to' => '17:00',
                        'capacity' => 5,
                        'max_capacity' => 30,
                    ],
                    [
                        'name' => 'Klinik Bedah Mulut',
                        'type' => 2,
                        'room' => 'Gedung Cokro Aminoto Lt.3',
                        'date_from' => 'Senin',
                        'date_to' => 'Jumat',
                        'time_from' => '13:00',
                        'time_to' => '17:00',
                        'capacity' => 1,
                        'max_capacity' => 15,
                    ],
                    [
                        'name' => 'Klinik Anak',
                        'type' => 1,
                        'room' => 'Gedung Cokro Aminoto Lt.3',
                        'date_from' => 'Senin',
                        'date_to' => 'Rabu',
                        'time_from' => '13:00',
                        'time_to' => '17:00',
                        'capacity' => 5,
                        'max_capacity' => 30,
                    ],
                    [
                        'name' => 'Klinik Bedah Mulut',
                        'type' => 2,
                        'room' => 'Gedung Cokro Aminoto Lt.3',
                        'date_from' => 'Senin',
                        'date_to' => 'Jumat',
                        'time_from' => '13:00',
                        'time_to' => '17:00',
                        'capacity' => 1,
                        'max_capacity' => 15,
                    ],
                    [
                        'name' => 'Klinik Anak',
                        'type' => 1,
                        'room' => 'Gedung Cokro Aminoto Lt.3',
                        'date_from' => 'Senin',
                        'date_to' => 'Rabu',
                        'time_from' => '13:00',
                        'time_to' => '17:00',
                        'capacity' => 5,
                        'max_capacity' => 30,
                    ],
                    [
                        'name' => 'Klinik Bedah Mulut',
                        'type' => 2,
                        'room' => 'Gedung Cokro Aminoto Lt.3',
                        'date_from' => 'Senin',
                        'date_to' => 'Jumat',
                        'time_from' => '13:00',
                        'time_to' => '17:00',
                        'capacity' => 1,
                        'max_capacity' => 15,
                    ],
                    [
                        'name' => 'Klinik Anak',
                        'type' => 1,
                        'room' => 'Gedung Cokro Aminoto Lt.3',
                        'date_from' => 'Senin',
                        'date_to' => 'Rabu',
                        'time_from' => '13:00',
                        'time_to' => '17:00',
                        'capacity' => 5,
                        'max_capacity' => 30,
                    ],
                    [
                        'name' => 'Klinik Bedah Mulut',
                        'type' => 2,
                        'room' => 'Gedung Cokro Aminoto Lt.3',
                        'date_from' => 'Senin',
                        'date_to' => 'Jumat',
                        'time_from' => '13:00',
                        'time_to' => '17:00',
                        'capacity' => 1,
                        'max_capacity' => 15,
                    ],
                    [
                        'name' => 'Klinik Anak',
                        'type' => 1,
                        'room' => 'Gedung Cokro Aminoto Lt.3',
                        'date_from' => 'Senin',
                        'date_to' => 'Rabu',
                        'time_from' => '13:00',
                        'time_to' => '17:00',
                        'capacity' => 5,
                        'max_capacity' => 30,
                    ],
                    [
                        'name' => 'Klinik Bedah Mulut',
                        'type' => 2,
                        'room' => 'Gedung Cokro Aminoto Lt.3',
                        'date_from' => 'Senin',
                        'date_to' => 'Jumat',
                        'time_from' => '13:00',
                        'time_to' => '17:00',
                        'capacity' => 1,
                        'max_capacity' => 15,
                    ],
                ];
            @endphp

            @foreach ($polikliniks as $poliklinik)
                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ asset('images/hospital.svg') }}" alt="Ikon Hospital" width="45" height="45"
                                    class="rounded-circle me-3 bg-danger">
                                <div>
                                    <h6 class="mb-0">{{ $poliklinik['name'] }}</h6>
                                    <small>{{ $poliklinik['room'] }}</small><br>
                                    @if ($poliklinik['type'] == 1)
                                        <span class="badge bg-danger-subtle text-danger mt-1">Pediatric</span>
                                    @else
                                        <span class="badge bg-info-subtle text-primary mt-1">Surgical</span>
                                    @endif
                                </div>
                            </div>

                            <p class="mt-2 mb-0">{{ $poliklinik['date_from'] }} - {{ $poliklinik['date_to'] }} |
                                {{ $poliklinik['time_from'] }} - {{ $poliklinik['time_to'] }}
                            </p>
                            <p>Kapasitas {{ $poliklinik['capacity'] }} / {{ $poliklinik['max_capacity'] }}
                            </p>
                            <a href="janji_temu.html" class="btn btn-danger btn-sm">Buat Janji Temu</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection