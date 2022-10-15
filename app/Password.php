<?php

namespace App;

use Illuminate\Support\Facades\Crypt;

class Password {
    public static function hash($pwd, $login) {
        return 'b_' . hash('sha512', $pwd . hash('crc32', $login));
    }
    /**
     * Check the password
     * @param $pass Password hash (hashed on the server side too)
     * @param $id User id (login or id)
     * @param $idtype Type of id, 1 = login 0 = id
     * @return integer|false Returns id of a password or false if there is no password
     */
    public static function check($pass, $id, $idtype = 1) {

        $uid = $idtype == 0 ? $id : 0;
        if ($idtype == 1) {
            $uid = DB::table('users')->where('login', $id)->get()[0]->id;
        }
        $pass = DB::table('user_password')->where('uid', $id)->where('active', true)->get();
        if (count($pass) == 0) return 0;
        return $pass[0]->id;
    }
}
