<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class AdminMiddleware
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
        $user = Auth::user();
        $status = $user->status ?? null;
        $active = in_array((string) $status, ['1', 'active'], true);

        if (Auth::check() && $user && (int) $user->is_admin === 1 && $active) 
        {
            # code...
            return $next($request);
        }
        else
        {
            return redirect()->route('thomas.admin.login');
        }
    }
}
