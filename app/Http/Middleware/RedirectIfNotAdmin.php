<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Auth::check() && \Auth::user()->role == 'admin') {
            // return redirect(env('FRONTEND_URL'));
            dd("here in side the admin middleware");
            return $next($request);
        }
        // return redirect(env('FRONTEND_URL'));
        return redirect($_ENV['FRONTEND_URL'] ? $_ENV['FRONTEND_URL'] : 'http://localhost:3000');
        // return $next($request);
    }
}
