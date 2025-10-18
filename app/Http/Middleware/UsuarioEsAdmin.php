<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class UsuarioEsAdmin
{
    public function handle(Request $request, Closure $next)
    {

        if (!auth()->user()->admin) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
