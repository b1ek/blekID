<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Account {
    /**
     * Create an account.
     * $data is an array of parameters:
     *  - login
     *  - password (SHA512)
     *  - email
     *  - name
     *  - appid
     *  - ip (optional)
     *  - useragent (optional)
     * @param array $data
     */
    public static function make(array $data) {

        $r = request();
        $time = time();
        $ip = isset($data['ip']) ? $data['ip'] : $r->ip();
        $userag = isset($data['useragent']) ? $data['useragent'] : $r->server('HTTP_USER_AGENT');

        DB::table('users')->insert(array(
            'registrator' => $data['appid'],
            'login' => $data['login'],
            'email' => $data['email'],
            'ip' => $ip,
            'user-agent' => $userag,
            'created' => $time,
            'deleted' => 0
        ));

        $user = DB::table('users')->where('created', $time)->where('login', $data['login'])->where('ip', $ip)->get()[0];

        DB::table('user_password')->insert(array(
            'uid' => $user->id,
            'hash' => \App\Password::hash($data['password'], $data['login']),
            'ip' => $ip,
            'user-agent' => $userag,
            'created' => time(),
            'active' => true
        ));

        return true;
    }
}
