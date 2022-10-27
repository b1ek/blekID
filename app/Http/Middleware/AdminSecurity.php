<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;

use Closure;
use Illuminate\Http\Request;

class AdminSecurity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        # if (ENV('APP_DEBUG')) return $next($request);

        if (!$request->session()->has('user_session')) abort(403);
        $s = $request->session();

        $session = \App\Session::check($s->get('user_session'), $s->get('used_pass'), true);

        // If the session exists
        if (gettype($session) != 'object') {
            if ($session == 3) {
                $ss = DB::table('user_session')->where('key', $s->get('user_session'))->get()[0];

                \App\Session::revoke($s->get('user_session'));
                $s->forget('user_session');
                return redirect(url('/auth/' . $ss->appid));
            }
            abort(401);
        }

        // get appid
        $appid = $session->appid;
        if (isset($_GET['appid'])) $appid = intval($_GET['appid']);

        $admin = DB::table('app_option')->where('key', 'admin')->where('appid', $appid)->get();
        if (count($admin) == 0) {
            abort(401);
        }

        // if its the admin
        if ($session->user == intval($admin[0]->value)) return $next($request);

        else abort(401);
    }
}
