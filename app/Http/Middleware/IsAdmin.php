<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !$user->is_admin) {
            abort(403, 'دسترسی غیرمجاز.');
        }

        return $next($request);
    }
}
