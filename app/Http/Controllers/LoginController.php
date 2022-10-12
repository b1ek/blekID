<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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
                \App\Session::revoke();
            }

            $session = DB::table('user_session')->where('key', $r->session()->get('user_session'));
            if ($session->count() != 0) return view('logined', array('appid' => $_GET['appid'], 'from' => 'login'));
        }

        // register a new session
        $token = \App\Session::make($data['login'], $data['password'], $data['appid']);
        $hash = \App\Password::hash($data['password']);

        if ($token !== false) {
            $r->session()->put('used_pass', $hash);
            return view('logined', array('appid' => $_GET['appid'], 'from' => 'login'));
        }

        $r->session()->put('used_pass', $hash);
        return view('auth', array('errors' => array(__('error.invalid_pass'))));
    }
    public function signup(Request $r) {

        if (!isset($_GET['complete'])) {
            return view('signup');
        }

        $data = $r->validate(array(
            'login' => 'required|string',
            'password' => 'required|regex:/^[a-f0-9]{128}/i',
            'appid' => 'required|integer',
            'email' => 'required|email:rfc,dns',
            'name' => 'required|string'
        ));

        if ($r->session()->has('user_session')) {
            \App\Session::revoke();
        }

        // Make the account
        \App\Account::make(array(
            'login' => $data['login'],
            'password' => $data['password'],
            'email' => $data['email'],
            'name' => $data['name'],
            'appid' => $data['appid'],
            'ip' => $r->ip(),
            'useragent' => $r->server('HTTP_USER_AGENT'),
        ));

        $pass = \App\Password::hash($data['password'], $data['login']);
        $r->session()->put('used_pass', $pass);

        // Log in (make the session)
        $key = \App\Session::make($data['login'], $pass, $data['appid'], false);

        return view('logined', array('appid' => $_GET['appid'], 'from' => 'signup'));

        return Redirect::away(\App\ExtApp::getRedirect($data['appid']) . '?from=singup&session=' . urlencode($key));
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
