<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $userType): Response
    {
        if (auth()->user()->role_id == $userType) {
            return $next($request);
        }

        return redirect()->route('front.login')->with('error', 'You do not have permission to access this page.');

        /* return response()->view('errors.check-permission'); */
        // return $next($request);
    }
}
