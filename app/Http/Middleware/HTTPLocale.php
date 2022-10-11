<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HTTPLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $r, Closure $next)
    {
        if ($r->session()->get('locale', 'none') != 'none') {
            \App::setLocale($r->session()->get('locale'));
            return $next($r);
        }
        $http_locale = 'en';
        foreach (config('app.locales') as $c => $k) {
            if (preg_match("/$c/", $r->server('HTTP_ACCEPT_LANGUAGE'))) {
                $http_locale = $c;
                break;
            }
        }
        \App::setLocale($http_locale);
        $r->session()->put('locale', $http_locale);
        return $next($r);
    }
}
