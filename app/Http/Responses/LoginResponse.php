<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $userRole = Auth::user()->getRoleNames()->toArray();
        $allowedRoles_frontend = ['administrator', 'superadmin', 'finances', 'supervisor', 'manager', 'assistant manager', 'audit', 'staff', 'financial-inside', 'maketing'];
        $allowedRoles_backend = ['financial', 'accountings'];

        if (count(array_intersect($allowedRoles_frontend, $userRole)) > 0) {
            session()->put('h_page', 'frontend');
        } elseif (count(array_intersect($allowedRoles_backend, $userRole)) > 0) {
            session()->put('h_page', 'backend');
        } else {
            session()->put('h_page', 'frontend');
        }

        return redirect()->intended('/home');
    }
}
