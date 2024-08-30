<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleOrPermissionMiddleware
{
    public function handle($request, Closure $next, $roleOrPermission, $guard = null)
    {
        $authGuard = Auth::guard($guard);
        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $rolesOrPermissions = is_array($roleOrPermission)
            ? $roleOrPermission
            : explode('|', $roleOrPermission);

        $userAllPermissions = $authGuard->user()->getAllPermissions()->pluck('name')->toArray();
        $missingPermissions = array_diff($rolesOrPermissions, $userAllPermissions);

        if (!empty($missingPermissions)) {
            throw UnauthorizedException::forRolesOrPermissions($missingPermissions);
        }else{
            $user = $authGuard->user();
            $hasAllRolesOrPermissions = collect($rolesOrPermissions)->every(function ($roleOrPermission) use ($user) {
                return $user->hasRole($roleOrPermission) || $user->hasPermissionTo($roleOrPermission);
            });

            if (!$hasAllRolesOrPermissions) {
                throw UnauthorizedException::forRolesOrPermissions($rolesOrPermissions);
            }
        }

        // if (! $authGuard->user()->hasAnyRole($rolesOrPermissions) && ! $authGuard->user()->hasAnyPermission($rolesOrPermissions)) {
        //     throw UnauthorizedException::forRolesOrPermissions($rolesOrPermissions);
        // }

        return $next($request);
    }
}
