<?php

use Illuminate\Support\Facades\Route;

// Importing routes from other files
Route::middleware('web')
  ->group(base_path('routes/front_end.php'))
  ->group(base_path('routes/auth.php'));

// Default route
Route::view('/', 'dashboard');
Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])
  ->name('dashboard');

Route::get('/janji-temu', fn() => view('janji-temu'))
  ->name('janji-temu');

Route::get('/dokter', fn() => view('dokter'))
  ->name('dokter');

Route::get('/poliklinik', fn() => view('poliklinik'))
  ->name('poliklinik');

Route::get('/tiket-antrian', fn() => view('tiket-antrian'))
  ->name('tiket-antrian');

Route::get('/bantuan', fn() => view('bantuan'))
  ->name('bantuan');

Route::prefix('admin')->middleware('admin')->group(function () {
  Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
  Route::get('/management-account', fn() => view('admin.management-account'))->name('admin.management-account');
});


Route::prefix('doctor')->middleware('doctor')->group(function () {
  Route::get('/dashboard', fn() => view('doctor.dashboard'))->name('doctor.dashboard');
  Route::get('/jadwal', fn() => view('doctor.jadwal'))->name('doctor.jadwal');
  Route::get('/antrian', fn() => view('doctor.antrian'))->name('doctor.antrian');
});


$hideNav = [
  'register',
  'login',
];
View::share('hideNavRoutes', $hideNav);
