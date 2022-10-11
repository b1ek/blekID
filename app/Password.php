<?php

namespace App;

use Illuminate\Support\Facades\Crypt;

class Password {
    public static function hash($pwd, $login) {
        return 'b_' . hash('sha512', $pwd . hash('crc32', $login));
    }
}
