@extends('layouts.app')

@section('content')

  <div class="container-fluid">
    <div class="container-fluid col-12 col-lg-15 px-4 py-3">
    <div
      class="banner position-relative p-4 rounded text-white d-flex align-items-center justify-content-between overflow-hidden mb-5"
      style="background: linear-gradient(135deg, #6B2C91, #7f4ea7); height: 250px;">
      <div style="z-index: 2; max-width: 60%;">
      <h2>Daftar Antrian Lebih Mudah</h2>
      <h6 class="fw-light">
        AppointDoc membantu Anda menemukan dan menjadwalkan<br>
        konsultasi dengan dokter profesional di RS Siaga Sedia.
      </h6><br>
      <h5>Semoga anda lekas sembuh</h5>
      </div>
      <img src="{{ asset('images/doctors_dashboard.png') }}" alt="Doctors" class="imgdashboard"
      style="max-height: 100%; object-fit: contain;" />
    </div>
    </div>
  </div>
@endsection