<?php

namespace App\Http\Middleware;

use Closure;
use User;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if (request('change_language')) {
            session()->put('language', request('change_language'));
            $language = request('change_language');
        } elseif (session('language')) {
            $language = session('language');
        } elseif  (!app()->runningInConsole() && auth()->check()) {
            $language = \Auth::user()->lang;
        } elseif (config('panel.primary_language')) {
            $language = config('panel.primary_language');
        }

        if (!app()->runningInConsole() && auth()->check()) {

        }

        if (isset($language)) {
            app()->setLocale($language);
        }

        return $next($request);
    }
}
