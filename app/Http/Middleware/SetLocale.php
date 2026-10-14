<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Use the browser's preferred supported language for every request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = config('app.fallback_locale', 'en');

        foreach ($request->getLanguages() as $language) {
            $language = strtolower(strtok($language, '_-'));

            if (in_array($language, ['de', 'en'], true)) {
                $locale = $language;
                break;
            }
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
