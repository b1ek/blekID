<?php

namespace App;

class Resource {

    /**
     * Get a public resource text.
     * If it doesnt exist, returns an empty string.
     */
    public static function get($path) {
        $path = base_path() . '/public/' . $path;
        if (file_exists($path)) return file_get_contents($path);
        return '';
    }
}
