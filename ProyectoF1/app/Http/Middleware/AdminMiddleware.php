<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado y es admin
        if (!$request->user() || $request->user()->role !== 'admin') {
            // Si no es admin, redirige a la página principal con un mensaje
            return redirect()->route('dashboard')
                ->with('error', 'Acceso denegado. No tienes permisos de administrador.');
        }

        // Si es admin, permite el acceso
        return $next($request);
    }
}
