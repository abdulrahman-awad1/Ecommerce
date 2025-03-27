<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('api_token');
        if ($token !== config('app.api_token')){
            return \Illuminate\Support\Facades\Response::json([
                'message'=>'invalid api token'
            ]);
        }
        return $next($request);
    }
}
