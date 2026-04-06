<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!Auth::check()) {
            abort(403, 'Для доступа необходимо авторизоваться');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->hasPermission($permission)) {
            abort(403, 'У вас нет прав для доступа к этой странице');
        }

        return $next($request);
    }
}
