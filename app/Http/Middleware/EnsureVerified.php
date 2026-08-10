<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVerified
{
    /**
     * Handle an incoming request.
     * Block access for warga whose accounts haven't been verified by admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isWarga() && !auth()->user()->isVerified()) {
            return redirect()->route('pending-verification');
        }

        return $next($request);
    }
}
