<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() === null) {
            return response("User not found", 404);
        }

        $actions = $request->route()->getAction();

        $role = (isset($actions['role']) ? $actions['role'] : null);

        if ($request->user()->hasRole($role)) {
            return $next($request);
        }

        return redirect('/');
        // return response("Unauthorized Role" , 404);
    }
}