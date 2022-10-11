<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct() {

    }
    public function index() {
        if (!ENV('APP_DEBUG')) return abort(404);
        return view('auth', array('locales' => config('app.locales')));
    }
    public function show(string $id) {
        if (!preg_match('/[0-9]/', $id)) return view('auth', array('locales' => config('app.locales')));
        $data = DB::table('apps')
                ->where('id', $id)
                ->limit(1)
                ->get()[0];

        return view('auth', array('locales' => config('app.locales'), 'app_name' => $data->public_name, 'appid' => $id));
    }
}
