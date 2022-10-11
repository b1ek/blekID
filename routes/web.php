<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

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
Route::apiResource('/qr', \App\Http\Controllers\QrCodeController::class);
Route::apiResource('/success', \App\Http\Controllers\ResourceController::class);

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
