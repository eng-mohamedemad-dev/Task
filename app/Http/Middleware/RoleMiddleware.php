<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request ;
use App\Traits\ApiResponseTrait;


class RoleMiddleware
{
    use ApiResponseTrait;
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!in_array($request->user()->role, $roles)) {
            return $this->errorResponse('Unauthorized', 403);
        }

        return $next($request);
    }
}
