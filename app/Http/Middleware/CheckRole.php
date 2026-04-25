<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $userRole = auth()->user()->role;
        
        // Si l'utilisateur a admin, il a accès à tout
        if ($userRole === 'admin') {
            return $next($request);
        }
        
        // Vérifier si le rôle de l'utilisateur est dans la liste autorisée
        if (!in_array($userRole, $roles)) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
