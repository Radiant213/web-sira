<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireAdmin2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isAdmin()) {
            if (!session('admin_2fa_passed')) {
                if (!$request->routeIs('admin.2fa') && !$request->routeIs('admin.2fa.*')) {
                    return redirect()->route('admin.2fa');
                }
            }
        }

        return $next($request);
    }
}
