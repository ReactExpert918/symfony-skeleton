<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EnsureToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = Cache::get('token_key');

        if (!$token) {
            return redirect('login');
        }

        return $next($request);
    }

}
