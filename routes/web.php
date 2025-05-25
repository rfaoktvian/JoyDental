<?php

use Illuminate\Support\Facades\Route;

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

// Handle authentication
use App\Http\Controllers\Auth\LoginController;

Route::get('login', [LoginController::class, 'showLoginForm'])
  ->name('login');

Route::post('login', [LoginController::class, 'login']);
Auth::routes();

$hideNav = [
  'register',
  'login',
];
View::share('hideNavRoutes', $hideNav);

use Illuminate\Http\Request;
use App\Models\User;

Route::get('/check-nik', function (Request $req) {
  return User::where('nik', $req->query('nik'))->exists()
    ? response()->noContent()
    : response()->json([], 404);
})->name('check.nik');
