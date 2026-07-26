<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Cek apakah role pengguna saat ini terdaftar pada parameter middleware
        if (in_array(auth()->user()->role, $roles)) {
            return $next($request);
        }

        // Jika tidak memiliki akses, kembalikan ke halaman sebelumnya atau beri pesan error
        abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}