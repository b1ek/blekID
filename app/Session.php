<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Session {

    /**
     * Create a user session.
     * @param $login Login of a user
     * @param $pass Password hash
     * @param $hash Defines whether the password needs to be hashed before inserting into the database.
     */
    public static function make($login, $pass, $appid, $hash = 0) {
        $r = request();

        if ($hash == 0) { // Password was hashed only on client side
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
    public static function revoke($appid = -1, $key = null) {
        $r = request();

        if ($key == null) {
            if (!$r->session()->has('user_session')) {
                throw new Exception('No session key specified');
            }
            $key = $r->session()->get('user_session');
        }

        if ($appid !== -1) {
            /**
             * Explanation:
             *
             * Imagine a situation in where a user is using 2 services with 2 sessions but with the same account.
             * One service decides to close the session.
             * But the another service's session is revoked, though it shouldn't have been.
             *
             * Altough there could be some cases where you should revoke all sessions of a user (for example, before deleting or freezing an account),
             * so this feature cannot be deleted.
             *
             * Please, make sure that you absolutely can't use an app id in this situation.
             * 
             * All pull requests that throw this warning will be a subject to review, and if you are using this in your PR,
             * please, save you and us some trouble - explain it in the PR readme.
             */
            trigger_error('App ID is not set, this is not a good practice. Please specify app ID unless you absolutely can\'t.', E_USER_WARNING);
            DB::table('user_session')->where('key', $key)->update(array('active' => false));
        }
        else
            DB::table('user_session')->where('key', $key)->where('appid', $appid)->update(array('active' => false));

        return true;
    }
}
