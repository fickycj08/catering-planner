<?php

use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\StaffDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\Staff\OrderStatusController;

Route::redirect('/', '/custom-login');
Route::get('/custom-login', function () {
    return view('custom-login');
});

Route::get('/custom-login', [\App\Http\Controllers\Auth\CustomLoginController::class, 'showLoginForm'])->name('custom.login');
Route::post('/custom-login', [\App\Http\Controllers\Auth\CustomLoginController::class, 'login']);
Route::get('/', [CustomLoginController::class, 'showLoginForm'])->name('custom.login');
Route::post('/', [CustomLoginController::class, 'login'])->name('custom.login.submit');


Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
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

Route::middleware('auth')
    ->get('/staff/jadwal', [StaffDashboardController::class, 'schedule'])
    ->name('staff.schedule');

Route::middleware(['auth', 'prevent_staff'])->prefix('staff')->group(function () {
    // Route untuk update status order
    Route::patch('orders/{order}/status', [OrderStatusController::class, 'update'])
        ->name('staff.orders.updateStatus');
});
