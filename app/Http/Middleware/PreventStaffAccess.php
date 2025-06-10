<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventStaffAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role !== 'staff') {
            return redirect('/');
        }

        return $next($request);
    }
}
