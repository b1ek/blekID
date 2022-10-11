<?php
namespace App;

use MatthiasMullie\Minify as Min;

class Minify {
    public static function css($text) {
        $minifier = new Min\CSS($text);

        return $minifier->minify();
    }
    public static function js($text) {
        $minifier = new Min\JS($text);

        return "\n" . $minifier->minify();
    }
}
