<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminSecurity;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function (Request $r) {
    return view('welcome');
});*/

Route::apiResource('/', \App\Http\Controllers\HomePageController::class);
Route::apiResource('/auth', \App\Http\Controllers\AuthController::class);
Route::apiResource('/login', \App\Http\Controllers\LoginController::class);
Route::apiResource('/signup', \App\Http\Controllers\LoginController::class);
Route::apiResource('/qr', \App\Http\Controllers\QrCodeController::class);
Route::apiResource('/reset', \App\Http\Controllers\PasswordResetController::class);

Route::view('/api/docs', 'api_docs');

Route::get('/setLocale/{new}', function(Request $r, string $new) {
    if (isset(config('app.locales')[$new])) {
        $r->session()->put('locale', $new);
    }
    return redirect()->back();
});

Route::get('/migrate', function() {
    if (!ENV('APP_DEBUG', false)) abort(403);
    Artisan::call('migrate:refresh', array('--force' => true));
    return 'Migration command is run successfully.';
});

Route::get('/debug', function() { // this is needed for debug purposes
    if (!ENV('APP_DEBUG', false)) abort(404);
    abort(400);
});

Route::get('/success', function() {
    return view('now_what');
});

Route::get('/logout', function() {
    if (request()->session()->has('user_session')) {
        \App\Session::revoke();
        request()->session()->forget('user_session');
        request()->session()->forget('used_pass');
    }

    return view('logged_out');
});

Route::middleware(AdminSecurity::class)->get('/admin', function() {
    return view('admin');
});
Route::middleware(AdminSecurity::class)->get('/admin/{panel}', function (string $panel) {
    return view('admin', array('panel' => $panel));
});
