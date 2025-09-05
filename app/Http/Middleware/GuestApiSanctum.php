<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Traits\ResponseTrait;

class GuestApiSanctum
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response|ResponseTrait
    {
         // The user must be guest
        if (Auth::guard('sanctum')->check())
            return $this->errorResponse('You already Logged in. !!', null, 400);

        return $next($request);
    }
}
