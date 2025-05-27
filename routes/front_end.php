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
    'label' => 'Dashboard',
    'icon' => 'fas fa-chart-line',
    'route' => 'dashboard',
    'pattern' => 'dashboard*',
  ],
  [
    'label' => 'Manajemen Akun',
    'icon' => 'fas fa-users-cog',
    'route' => 'dashboard',
    'pattern' => 'manage-akun*',
  ],
  [
    'label' => 'Grafik Antrian',
    'icon' => 'fas fa-chart-pie',
    'route' => 'dashboard',
    'pattern' => 'grafik-antrian*',
  ],
  [
    'label' => 'Kelola Poliklinik',
    'icon' => 'fas fa-clinic-medical',
    'route' => 'dashboard',
    'pattern' => 'manage-poliklinik*',
  ],
];
View::share('siderbarAdminMenu', $siderbarAdminMenu);


$sidebarDokterMenu = [
  [
    'label' => 'Dashboard',
    'icon' => 'fas fa-tachometer-alt',
    'route' => 'dashboard',
    'pattern' => 'dashboard*',
  ],
  [
    'label' => 'Lihat Jadwal Saya',
    'icon' => 'fas fa-calendar-day',
    'route' => 'dashboard',
    'pattern' => 'jadwal-dokter*',
  ],
  [
    'label' => 'Antrian Pasien',
    'icon' => 'fas fa-users',
    'route' => 'dashboard',
    'pattern' => 'antrian-pasien*',
  ],
  [
    'label' => 'Riwayat Konsultasi',
    'icon' => 'fas fa-history',
    'route' => 'dashboard',
    'pattern' => 'riwayat-konsultasi*',
  ],
];
View::share('sidebarDokterMenu', $sidebarDokterMenu);

