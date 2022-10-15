<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Session {

    /**
     * Create a user session.
     * @param $login Login of a user
     * @param $pass Password hash
     * @param $appid App id
     * @param $hash Whether the password was hashed on server side.
     */
    public static function make($login, $pass, $appid, $hash = false) {
        $r = request();

        if (!$hash) { // Password was hashed only on client side
            $pass = Password::hash($pass, $login);
        }

        $users = DB::table('users')
                  ->where('login', $login)
                  ->select('user_password.hash as pass', 'users.*', 'user_password.uid', 'user_password.id as pid')
                  ->join('user_password', 'user_password.uid', '=', 'users.id')
                  ->join('user_password', 'user_password.active', '=', DB::raw('true'))
                  ->get();

        foreach ($users as $i => $user) {
            if ($user->pass == $pass) {

                // revoke any other session for this user
                $sessions = DB::table('user_session')->where('user', $user->id)->update(array('active' => false));

                $session_key = \Str::random(256);
                DB::table('user_session')
                  ->insert(array(
                      'key' => $session_key,
                      'used_password' => $pass,
                      'appid' => $appid,
                      'lastAccess' => time(),
                      'ip' => $r->ip(),
                      'user-agent' => $r->userAgent(),
                      'user' => $user->id,
                  ));
                $r->session()->put('user_session', $session_key);
                $r->session()->put('used_pass',    $pass       );
                return $session_key;
            }
        }

        return false;
    }

    /**
     * Revoke the session by key
     * @param $key If you don't specify the key, session key from laravel session will be used.
     */
    public static function revoke($key = null) {
        $r = request();

        if ($key == null) {
            if (!$r->session()->has('user_session')) {
                throw new Exception('No session key specified');
            }
            $key = $r->session()->get('user_session');
        }

        DB::table('user_session')->where('key', $key)->update(array('active' => false));

        return true;
    }

    /**
     * Check the session
     * @param $key Sessions key
     * @param $pass Password
     * @param $hashed Whether the password was hashed on server side
     * @return int|stdClass stdClass with session data if session exists, 1 if session is not active, 2 if no user is with this session, 3 if passwords dont match
     */
    public static function check($key, $pass, $hashed = false) {

        $session = DB::table('user_session')->where('key', $key)->where('active', true)->get();
        if (count($session) == 0) return 1;

        $user = DB::table('users')->where('id', $session[0]->user)->get();
        if (count($user) == 0) {
            DB::table('user_session')->where('user', $session[0]->user)->update(array('active' => false));
            return 2;
        }

        if (!$hashed) $pass = \App\Password::hash($pass, $user->login);

        $passw = DB::table('user_password')->where('active', true)->where('uid', $session[0]->user)->get();
        if (count($passw) == 0) return 3;

        if (((array)$session[0])['used_password'] == $passw[0]->hash) {
            return $session[0];
        }
        return 3;

    }
}
