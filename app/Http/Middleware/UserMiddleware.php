<?php
// File: app/Http/Middleware/UserMiddleware.php
// Fungsi: Middleware untuk memastikan yang akses adalah user biasa

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan rolenya user
        if (auth()->check() && auth()->user()->isUser()) {
            return $next($request);
        }

        // Kalau bukan user biasa, redirect ke dashboard admin
        return redirect()->route('admin.dashboard')->with('error', 'Anda tidak punya akses ke halaman ini!');
    }
}
