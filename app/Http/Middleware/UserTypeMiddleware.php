<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class UserTypeMiddleware
{

    protected $roles= [
        'superadmin'    => 4,
        'admin'         => 3,
        'company'       => 2,
        'user'          => 1
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        if ($request->user()->role < ($this->roles[$role])) {
            return response('Unauthorized.', 401);
        }

        return $next($request);


    }
}
