<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockAdminFromIntake
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()?->rol === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}
