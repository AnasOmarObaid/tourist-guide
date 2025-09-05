<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Traits\ResponseTrait;

class EnsureApiAuthenticated
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response|ResponseTrait
    {
        // Check if the user is not authenticated
        if (!Auth::guard('sanctum')->check())
            return $this->errorResponse('You must be logged in to access this resource.', null, 401);

        return $next($request);
    }
}
