<?php
// File: app/Http/Middleware/AdminMiddleware.php
// Fungsi: Middleware untuk memastikan yang akses adalah admin

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan rolenya admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }

        // Kalau bukan admin, redirect ke dashboard user
        return redirect()->route('user.dashboard')->with('error', 'Anda tidak punya akses ke halaman ini!');
    }
}
