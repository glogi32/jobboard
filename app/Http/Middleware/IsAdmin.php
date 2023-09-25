<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session("user")?->role_id == 1) {
            return $next($request);
        } else {
            Log::warning('User tried to gain unauthorized access to page');
            return redirect()->back();
        }
    }
}
