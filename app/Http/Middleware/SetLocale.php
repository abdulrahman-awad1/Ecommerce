<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // الحصول على اللغة من الـ request
        $lang = $request->header('Accept-Language') ?: $request->query('lang', 'en'); // مع دعم lang من الـ query string

        // تعيين اللغة للتطبيق
        if (in_array($lang, ['en', 'ar'])) {
            LaravelLocalization::setLocale($lang);
        }
        return $next($request);
    }
}
