<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Controleer of de gebruiker CEO is en geef volledige toegang
        if ($user && $user->role->id === 10) {
            return $next($request);
        }

        // Controleer of de gebruiker de juiste rol heeft voor de route
        if ($user && in_array($user->role->id, $roles)) {
            return $next($request);
        }

        // Als de gebruiker geen rechten heeft, geef een foutmelding
        return redirect()->route('forbidden')->withErrors('Je hebt geen toegang tot deze pagina.');
    }
}
