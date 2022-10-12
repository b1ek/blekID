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
