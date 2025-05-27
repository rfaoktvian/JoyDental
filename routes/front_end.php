<?php

$sidebarMenu = [
  [
    'label' => 'Dashboard',
    'icon' => 'fas fa-home',
    'route' => 'dashboard',
    'pattern' => 'dashboard*',
  ],
  [
    'label' => 'Janji Temu',
    'icon' => 'fas fa-calendar-alt',
    'route' => 'janji-temu',
    'pattern' => 'janji-temu*',
  ],
  [
    'label' => 'Dokter',
    'icon' => 'fas fa-user-md',
    'route' => 'dokter',
    'pattern' => 'dokter*',
  ],
  [
    'label' => 'Poliklinik',
    'icon' => 'fas fa-hospital',
    'route' => 'poliklinik',
    'pattern' => 'poliklinik*',
  ],
  [
    'label' => 'Bantuan',
    'icon' => 'fas fa-question-circle',
    'route' => 'bantuan',
    'pattern' => 'bantuan*',
  ],
];
View::share('sidebarMenu', $sidebarMenu);

$siderbarAdminMenu = [
  [
    'label' => 'Dashboard Admin',
    'icon' => 'fas fa-chart-line',
    'route' => 'admin.dashboard',
    'pattern' => 'admin.dashboard*',
  ],
  [
    'label' => 'Manajemen Akun',
    'icon' => 'fas fa-users-cog',
    'route' => 'admin.users',
    'pattern' => 'admin.users*',
  ],
];
View::share('siderbarAdminMenu', $siderbarAdminMenu);


$sidebarDokterMenu = [
  [
    'label' => 'Dashboard',
    'icon' => 'fas fa-tachometer-alt',
    'route' => 'doctor.dashboard',
    'pattern' => 'doctor.dashboard*',
  ],
  [
    'label' => 'Lihat Jadwal Saya',
    'icon' => 'fas fa-calendar-day',
    'route' => 'doctor.jadwal',
    'pattern' => 'doctor.jadwal*',
  ],
  [
    'label' => 'Antrian Pasien',
    'icon' => 'fas fa-users',
    'route' => 'doctor.antrian',
    'pattern' => 'doctor.antrian*',
  ],
];
View::share('sidebarDokterMenu', $sidebarDokterMenu);

