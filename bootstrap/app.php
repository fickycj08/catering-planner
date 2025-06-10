<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;                            // ← Import Route
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\PreventStaffAccess;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Daftarkan alias route-middleware dengan aliasMiddleware
            Route::aliasMiddleware('is_admin', IsAdmin::class);
            Route::aliasMiddleware('prevent_staff', PreventStaffAccess::class);
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
