<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Default route
Route::view('/', 'dashboard');
Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index']);

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
    'label' => 'Tiket Antrian',
    'icon' => 'fas fa-notes-medical',
    'route' => 'tiket-antrian',
    'pattern' => 'tiket-antrian*',
  ],
  [
    'label' => 'Bantuan',
    'icon' => 'fas fa-question-circle',
    'route' => 'bantuan',
    'pattern' => 'bantuan*',
  ],
];
View::share('sidebarMenu', $sidebarMenu);


$hideNav = [
  'register',
  'login',
];
View::share('hideNavRoutes', $hideNav);

// Handle authentication
use App\Http\Controllers\Auth\LoginController;

Route::get('login', [LoginController::class, 'showLoginForm'])
  ->name('login');

Route::post('login', [LoginController::class, 'login']);
Auth::routes();


Route::get('/check-nik', function (Request $req) {
  return User::where('nik', $req->query('nik'))->exists()
    ? response()->noContent()
    : response()->json([], 404);
})->name('check.nik');

