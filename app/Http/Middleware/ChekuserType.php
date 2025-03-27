<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChekuserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user(); //v دا بيجيب اليوزر ال عامل لوجين وعمل ريكويست
        if (!$user){
            return redirect()->route('login');//c لو اليوزر مش لوجين رجعه ل روات اللوجين
        }
        if ($user =='user'){
             abort('403');
        }

        return $next($request);//b دي موجوده بشكل افتراضي
    }
}
