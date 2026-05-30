<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('locale')) {
            \Illuminate\Support\Facades\App::setLocale(session()->get('locale'));
        } else {
            \Illuminate\Support\Facades\App::setLocale('id');
        }

        return $next($request);
    }
}
