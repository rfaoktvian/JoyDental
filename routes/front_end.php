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
    'label' => 'Riwayat Medis',
    'icon' => 'fas fa-file-medical-alt',
    'route' => 'riwayat-medis',
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
    'label' => 'Bantuan',
    'icon' => 'fas fa-question-circle',
    'route' => 'bantuan',
  ],
];
View::share('sidebarMenu', $sidebarMenu);

$siderbarAdminMenu = [
  [
    'label' => 'Dashboard Admin',
    'icon' => 'fas fa-chart-line',
    'route' => 'admin.dashboard',
  ],
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
  [
    'label' => 'Manajemen Antrian',
    'icon' => 'fas fa-list-ol',
    'route' => 'admin.antrian',
  ],
  [
    'label' => 'Laporan & Statistik',
    'icon' => 'fas fa-chart-bar',
    'route' => 'admin.laporan',
  ],
];
View::share('siderbarAdminMenu', $siderbarAdminMenu);


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
    'label' => 'Rekam Medis',
    'icon' => 'fas fa-file-medical',
    'route' => 'doctor.rekam-medis',
  ],
  [
    'label' => 'Riwayat Konsultasi',
    'icon' => 'fas fa-history',
    'route' => 'doctor.riwayat',
  ],
  [
    'label' => 'Profil Dokter',
    'icon' => 'fas fa-id-card',
    'route' => 'doctor.profil',
  ],
  [
    'label' => 'Laporan Harian',
    'icon' => 'fas fa-file-alt',
    'route' => 'doctor.laporan',
  ],
];
View::share('sidebarDokterMenu', $sidebarDokterMenu);

