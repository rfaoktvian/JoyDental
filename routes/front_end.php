<?php

$sidebarMenu = [
  [
    'label' => 'Dashboard',
    'icon' => 'fas fa-home',
    'route' => 'dashboard',
  ],
  [
    'auth' => true,
    'label' => 'Janji Temu',
    'icon' => 'fas fa-calendar-alt',
    'route' => 'janji-temu',
  ],
  [
    'auth' => true,
    'label' => 'Tiket Antrian',
    'icon' => 'fas fa-ticket-alt',
    'route' => 'tiket-antrian',
  ],
  [
    'label' => 'Dokter',
    'icon' => 'fas fa-user-md',
    'route' => 'dokter',
  ],
  [
    'label' => 'Poliklinik',
    'icon' => 'fas fa-hospital',
    'route' => 'poliklinik',
  ],
  [
    'auth' => true,
    'label' => 'Profil Saya',
    'icon' => 'fas fa-file-medical-alt',
    'route' => 'profil',
  ],
  [
    'label' => 'Bantuan',
    'icon' => 'fas fa-question-circle',
    'route' => 'bantuan',
  ],
];
View::share('sidebarMenu', $sidebarMenu);


$sidebarDokterMenu = [
  [
    'label' => 'Dashboard',
    'icon' => 'fas fa-tachometer-alt',
    'route' => 'doctor.dashboard',
  ],
  [
    'label' => 'Antrian Pasien',
    'icon' => 'fas fa-users',
    'route' => 'doctor.antrian',
  ],
  [
    'label' => 'Pasien',
    'icon' => 'fas fa-file-medical',
    'route' => 'doctor.pasien',
  ],
  [
    'label' => 'Riwayat Konsultasi',
    'icon' => 'fas fa-history',
    'route' => 'doctor.riwayat',
  ],
  [
    'label' => 'Laporan Harian',
    'icon' => 'fas fa-file-alt',
    'route' => 'doctor.laporan',
  ],
  [
    'auth' => true,
    'label' => 'Profil Dokter',
    'icon' => 'fas fa-file-medical-alt',
    'route' => 'doctor.profile',
  ],
];
View::share('sidebarDokterMenu', $sidebarDokterMenu);

$siderbarAdminMenu = [
  [
    'label' => 'Manajemen Pengguna',
    'icon' => 'fas fa-users-cog',
    'route' => 'admin.users',
  ],
  [
    'label' => 'Manajemen Dokter',
    'icon' => 'fas fa-user-md',
    'route' => 'admin.dokter',
  ],
  [
    'label' => 'Manajemen Poliklinik',
    'icon' => 'fas fa-hospital-alt',
    'route' => 'admin.poliklinik',
  ],
];
View::share('siderbarAdminMenu', $siderbarAdminMenu);
