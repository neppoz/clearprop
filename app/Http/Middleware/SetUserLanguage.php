<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class SetUserLanguage
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $locale = session('locale', $user->lang ?? config('app.locale'));

            App::setLocale($locale);

            if (session('locale') !== $user->lang) {
                $user->update(['lang' => $locale]);
            }

            session()->put('locale', $locale);
        }

        return $next($request);
    }
}
