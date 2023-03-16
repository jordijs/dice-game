<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSelfPlayer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //The ID in the URL
        $idRequested = $request->route('id');
        //The ID of the authenticated user
        $idAuthenticated = $request->user()->id;

        if (! ($idRequested == $idAuthenticated)) {
            throw new Exception("Acces denied. You can only access your own data", 403);
        }
        return $next($request);
    }
}
