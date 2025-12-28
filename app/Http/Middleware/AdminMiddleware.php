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
        //We gaan nakijken od de user logged in is en of het daadwerkelijk de admin is
        if(!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Geen toegan. Alleen admins hebben toegang tot deze pagin.');
        }
        return $next($request);
    }
}
