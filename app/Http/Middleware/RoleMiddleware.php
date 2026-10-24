<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || $request->user()->role !== $role) {
            $correctRoute = $request->user()->role === 'merchant' 
                ? 'merchant.dashboard' 
                : 'customer.dashboard';

            return redirect()->route($correctRoute)->with('error', 'Akses ditolak: Anda dialihkan ke dashboard sesuai role akun Anda.');
        }

        return $next($request);
    }
}