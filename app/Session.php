<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Session {

    /**
     * Create a user session.
     * @param $login Login of a user
     * @param $pass Password hash
     * @param $appid App id
     * @param $hash Defines whether the password was hashed only on client side.
     */
    public static function make($login, $pass, $appid, $hash = true) {
        $r = request();

        if ($hash) { // Password was hashed only on client side
            $pass = Password::hash($pass, $login);
        }

        $users = DB::table('users')
                  ->where('login', $login)
                  ->select('user_password.hash as pass', 'users.*', 'user_password.uid', 'user_password.id as pid')
                  ->join('user_password', 'user_password.uid', '=', 'users.id')
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
}
