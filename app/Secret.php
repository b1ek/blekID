<?php

namespace App;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Str;

function rstr($length = 16) {
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}

class Secret {
    public static function create($app_name, $id) {
        return Crypt::encryptString($id . hash('sha256', $app_name . time()) . rstr(64));
    }
}
