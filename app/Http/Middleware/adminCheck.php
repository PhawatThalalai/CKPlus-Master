<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;

class adminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() != NULL) {
            if (Auth::user()->position == 'Admin') {
                return $next($request);
                // return redirect()->route('dashboard');
            } else {
                // dd(Auth::user());
                // return view('dashboard');
                return redirect()->route('home.index');
            }
        } else {
            return redirect()->back();
        }
    }
}
