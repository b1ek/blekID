<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('check_login', function (Request $r) {
    $login = $r->validate(array('login' => 'required|string'))['login'];
    $logins = DB::table('users')->where('login', $login)->count();
    if ($logins == 0) return 'true';
    else return $login . '_' . rand($logins + 600, $logins + 1000);
});

Route::get('userdata', function (Request $r) {
    $data = $r->validate(array(
        'id' => 'required|string',
        'appid' => 'required|integer',
        'secret' => 'required|string'
    ));

    $app = DB::table('apps')->where('id', $data['appid'])->where('secret', $data['secret'])->get();

    if (count($app) == 0) { // app id or secret is wrong
        return response('Invalid app id or secret key.', 401);
    }

    $session = DB::table('user_session')->where('key', $data['id'])->where('appid', $data['appid'])->get()[0];

    $user = DB::table('users')
        ->where('id', $session->user)
        ->get()[0];

    $pass = DB::table('user_password')->where('uid', $user->id)->where('hash', $session->used_password)->get()[0];

    $userdata = DB::table('user_data')->where('uid', $user->id)->get();

    return array(
        'id' => $user->id,
        'login' => $user->login,
        'email' => $user->email,
        'passhash' => $pass->hash,
        'created' => $user->created,
        'data' => $userdata
    );

});

Route::get('login', function (Request $r) {

    abort(401);

    $data = $r->validate(array(
        'appid' => 'required|integer',
        'login' => 'required|string',
        'pass' => 'required|regex:/[a-f0-9]{128}/i',
        'secret' => 'required|string',
    ));

    $app = DB::table('apps')->where('id', $data['appid'])->where('secret', $data['secret'])->get();

    if (count($app) == 0) { // app id or secret is wrong
        return response('Invalid app id or secret key.', 401);
    }

    $token = \App\Session::make($data['login'], $data['pass'], $data['appid']);
    if ($token == false) {
        return 'Z_1';
    }

    return $token;
});
