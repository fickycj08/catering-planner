<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\StaffDashboardController;

Route::redirect('/', '/welcome');
Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/staff/login', [StaffAuthController::class, 'showLoginForm'])->name('staff.login');
Route::post('/staff/login', [StaffAuthController::class, 'login']);
Route::post('/staff/logout', [StaffAuthController::class, 'logout'])->name('staff.logout');
Route::middleware('auth')->get('/staff/dashboard', function () {
    return view('staff.dashboard');
})->name('staff.dashboard');
Route::get('/staff/register', [StaffAuthController::class, 'showRegisterForm'])->name('staff.register');
Route::post('/staff/register', [StaffAuthController::class, 'register'])->name('staff.register');

Route::post('/staff/register', [StaffAuthController::class, 'register']);

Route::middleware('auth')->get('/staff/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');