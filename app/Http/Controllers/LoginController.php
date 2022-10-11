<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    public function login(Request $r) {

        // get http args
        $data = $r->validate(array(
            // login is a string
            'login' => 'required|string',
            // password must be a sha512 string
            'password' => 'required|regex:/^[a-f0-9]{128}i/',
            'appid' => 'required|integer'
        ));

        // If user is logged in
        if ($r->session()->has('user_session')) {
            if (ENV('APP_DEBUG', false)) {
                $r->session()->forget('user_session');
            }

            $session = DB::table('user_session')->where('key', $r->session()->where('appid', $data['appid'])->get());
            if (isset($_GET['appid'])) {
                return view('logined', array('appid' => $_GET['appid']));
            }

            abort(400, 'App ID must be specified. Please contact the site administrator.');
        }

        // register a new session
        $token = \App\Session::make($data['login'], $data['password'], $data['appid']);
        if ($token !== false) {
            return view('logined', array('appid' => $_GET['appid']));
        }
        return view('auth', array('errors' => array(__('error.invalid_pass'))));
    }
    public function signup(Request $r) {
        $data = $r->validate(array(
            'login' => 'required|string',
            'password' => 'required|regex:/^[a-f0-9]{128}/i',
            'appid' => 'required|integer'
        ));

        if ($r->session()->has('user_session')) {
            \App\Session::revoke();
        }
    }

    public function index(Request $r) {

        if ($_GET['action'] == 'login') {
            return $this->login($r);
        }
        if ($_GET['action'] == 'signup') {
            return $this->signup($r);
        }
        return redirect('/auth');
    }
}
