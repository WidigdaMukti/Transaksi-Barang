<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EnsureAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah token ada di session dan pengguna tidak berada di halaman login
        if (!$request->session()->has('token') && $request->path() !== 'login') {
            // Jika tidak ada token dan bukan di halaman login, arahkan ke halaman login
            return redirect('/login');
        }

        return $next($request);
    }
}
