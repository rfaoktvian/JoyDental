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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Handle Check Email
use Illuminate\Http\Request;
use App\Models\User;

Route::get('/check-email', function (Request $req) {
  $email = $req->query('email');
  if (!$email) {
    return response()->json(['error' => 'email missing'], 400);
  }
  return User::where('email', $email)->exists()
    ? response()->noContent()
    : response()->json(['message' => 'not found'], 404);
})->name('check.email');