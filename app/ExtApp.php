<?php

namespace App;

use Illuminate\Support\Facades\DB;

/**
 * This class handles all external app communications
 */
class ExtApp {
    /**
     * Get app redirect
     */
    public static function getRedirect($appid, $id = 'success') {
        $redir = DB::table('app_redirect')->where('appid', $appid)->where('id', $id);
        if ($redir->count() != 0) return $redir->get()[0]->link;
        return false;
    }
}
