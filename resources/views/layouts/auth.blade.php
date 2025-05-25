@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
<div class="auth-container">

  <div class="auth-left">
    <img src="{{ asset('images/doctors_login.png') }}" alt="Doctors">
  </div>

  <div class="auth-right">
    <div class="form-wrapper">
      <main>
        @yield('sub_content')
      </main>
    </div>
  </div>

</div>
@endsection