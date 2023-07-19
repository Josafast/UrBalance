<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Language
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->cookie('locale', $request->getPreferredLanguage(['es', 'en']));
        app()->setLocale($locale);
        return $next($request);
    }
}
