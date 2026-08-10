<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user has the Spatie role or the legacy enum role
        if (!$user->hasRole($role) && $user->role !== $role) {
            if ($user->hasRole('admin') || $user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('warga.dashboard');
        }

        return $next($request);
    }
}
