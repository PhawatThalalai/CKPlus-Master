<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfigureFrontends
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {
        // dump('ConfigureFrontends');
        session()->put('h_page', 'frontend');

        // $allowedRoles = ['admin', 'manager', 'staff'];
        // $userRole = auth()->user()->getRoleNames()->toArray();

        // if (Auth::check() && count(array_intersect($allowedRoles, $userRole)) > 0) {
        //     // return redirect('/home')->withErrors(['message' => 'Access denied.']);
        //     return $next($request);
        // } else {
        //     dd('Access denied.');
        // }

        return $next($request);
    }
}
