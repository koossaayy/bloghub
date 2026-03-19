<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAuteur
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || 
            (!auth()->user()->isAuteur() && !auth()->user()->isAdmin())) {
            abort(403, 'Accès refusé');
        }

        return $next($request);
    }
}