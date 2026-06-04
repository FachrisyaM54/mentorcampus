<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // sesuaikan dengan role admin di database
        if (Auth::user()->id_role != 1) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}