<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
    
            if ($user->hasRole('guru')) {
                return redirect('/guru');
            }
    
            if ($user->hasAnyRole(['admin', 'super-admin'])) {
                return redirect('/admin');
            }
        }
    
        return $next($request);
    }
}
