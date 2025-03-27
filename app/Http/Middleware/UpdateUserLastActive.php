<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLastActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request-> user(); // or  دي او دي   $user= auth()->user();
        if ($user instanceof User){
            $user->forceFill([  //fillable استخدمتها لان مش متعرفه ف ال forceFill
                'last_active_at'=>carbon::now() //now دي فانكشن بترجع الوقت
            ])
                ->save();

        }
        return $next($request);
    }
}
