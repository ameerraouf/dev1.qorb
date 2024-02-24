<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
                // Check if the user is logged in
        if (Auth::check()) {
            // Check if the user is an admin
            if (Auth::user()->role === 'admin') {
                // If the user is an admin, redirect to the admin page
                return $next($request);
            }
            else if(Auth::user()->role === 'specialist'){
                return redirect()->route('specialistHome');
            }
            else if(Auth::user()->role === 'supervisor'){
                return redirect()->route('supervisorHome');
            }
        }

        // If not an admin, proceed with the request
        return redirect()->route('Home');
    }
}
