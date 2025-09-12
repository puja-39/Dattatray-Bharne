<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log; 

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next): Response
    {
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
            Log::info('Middleware hit. Session locale: ' . session('locale')); 
        }

        return $next($request);
    }
}
