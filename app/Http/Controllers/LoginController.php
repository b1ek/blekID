<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{

    public function login(Request $r) {

        // If user is logged in already
        if ($r->session()->has('user_session')) {

            $session = DB::table('user_session')->where('key', $r->session()->get('user_session'))->get();

            if (count($session) == 0) {
                \App\Session::revoke();
                return redirect()->to(url('/auth/' . $_GET['appid']));
            }

            return view('logined', array('appid' => $_GET['appid'], 'from' => 'login'));
        }

        // get http args
        $data = $r->validate(array(
            // login is a string
            'login' => 'required|string',
            // password must be a sha512 string
            'password' => 'required|regex:/^[a-f0-9]{128}/i',
            'appid' => 'required|integer'
        ));

        // check if login is the right login
        $users = DB::table('users')
            ->where('login', $data['login'])
            ->get();
        if (count($users) == 0) {
            return view('auth', array('appid' => $data['appid'], 'errors' => array(__('error.no_user'))));
        }

        // register a new session
        $token = \App\Session::make($data['login'], $data['password'], $data['appid']);
        $hash = \App\Password::hash($data['password'], $data['login']);


        if ($token == false) {
            return view('auth', array('appid' => $data['appid'], 'errors' => array(__('error.invalid_pass'))));
        }
        $r->session()->put('used_pass', $hash);
        return view('logined', array('appid' => $_GET['appid'], 'from' => 'login'));

    }
    public function signup(Request $r) {

        if (!isset($_GET['appid'])) abort(400);

        $reg_disabled = DB::table('app_option')->where('appid', $_GET['appid'])->where('key', 'reg_disabled')->count();
        if ($reg_disabled) abort(403);

        if (!isset($_GET['complete'])) {
            return view('signup');
        }

        $invonly = DB::table('app_invites')->where('appid', $_GET['appid'])->count() != 0;

        $data = $r->validate(array(
            'login' => 'required',
            'password' => 'required|regex:/^[a-f0-9]{128}/i',
            'appid' => 'required|integer',
            'email' => 'required|string',
            'name' => 'required|string',
            'invite' => ($invonly ? 'required|' : '') . 'string'
        ));


        if ($invonly) {
            $valid = DB::table('app_invites')->where('appid', $data['appid'])->where('invite_key', $data['invite'])->count() != 0;
            if (!$valid) {
                return view('signup', array('err' => 'Invalid invite code.'));
            }
        }

        if ($r->session()->has('user_session')) {
            \App\Session::revoke();
        }

        if (DB::table('users')->where('login', $data['login'])->count() != 0) {
            return view('signup', array('err' => 'This login is already used. Try ' . $data['login'] . '_' . rand(1000, 9999) . ' instead.'));
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
    }


    public function index(Request $r) {

        if (!isset($_GET['action'])) return '';

        if ($_GET['action'] == 'login') {
            return $this->login($r);
        }
        if ($_GET['action'] == 'signup') {
            return $this->signup($r);
        }
        return redirect('/auth');
    }
}
