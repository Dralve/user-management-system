<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = auth()->user();

        // Check if user has the required permission using hasPermission method
        if ($user && $user->hasPermission($permission)) {
            return $next($request);
        }

        // If the user doesn't have the permission, return an error response
        return response()->json(['message' => 'Forbidden'], 403);
    }
}
