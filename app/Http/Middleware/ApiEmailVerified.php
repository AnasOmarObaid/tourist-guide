<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ApiEmailVerified
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response|ResponseTrait
    {
        if(!Auth::guard('sanctum')->user()->hasVerifiedEmail()){
            return $this->errorResponse('unverified email', 'verify the email', 403);
        }
        return $next($request);
    }
}
