<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminSecurity;

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

Route::prefix('admin')->middleware(AdminSecurity::class)->group(function() {

    Route::get('/get_all_users', function (Request $r) {
        return DB::table('users')->join('apps', 'apps.id', '=', 'users.registrator')->get(array(
            'users.id',
            'users.login',
            'users.email',
            'users.ip',
            'users.created',
            'users.user-agent',
            'users.deleted',
            'users.frozen',

            'apps.name as registrator-app',
            'users.registrator'
        ));
    });

    Route::get('get_all_users_search', function(Request $r) {return redirect('/api/admin/get_all_users');});

    Route::get('get_all_users_search/{string}', function (Request $r, string $pattern) {
        $pattern = "/.*$pattern.*/i";
        $found = DB::table('users')->join('apps', 'apps.id', '=', 'users.registrator')->get(array(
            'users.id',
            'users.login',
            'users.email',
            'users.ip',
            'users.created',
            'users.user-agent',
            'users.deleted',
            'users.frozen',

            'apps.name as registrator-app',
            'users.registrator'
        ));

        $searchd = array();

        foreach ($found as $i => $user) {
            if (preg_match($pattern, $user->login)) {
                array_push($searchd, $user);
            }
        }

        return $searchd;
    });

    Route::get('/get_all_apps', function (Request $r) {
        return DB::table('apps')->get(array(
            'id', 'name', 'public_name', 'contact', 'link', 'created', 'suspended'
        ));
    });

    Route::get('delete/{user}', function (string $user) {
        $users = DB::table('users')->where('id', $user)->get();
        if (count($users) == 0) abort(400);

        if ($users[0]->deleted == 0)
            DB::table('users')->where('id', $user)->update(array('deleted' => time()));
        else
            DB::table('users')->where('id', $user)->update(array('deleted' => 0));
    });

    Route::get('freeze/{user}', function (string $user) {
        $users = DB::table('users')->where('id', $user)->get();
        if (count($users) == 0) abort(400);

        if ($users[0]->frozen == 0)
            DB::table('users')->where('id', $user)->update(array('frozen' => true));
        else
            DB::table('users')->where('id', $user)->update(array('frozen' => false));
    });

    Route::get('change_pass/{user}/{pass}', function (string $user, string $pass) {
        $users = DB::table('users')->where('id', $user)->get();
        // if user id is invalid
        if (count($users) == 0) abort(400);
        $uuser = $users[0];

        $delete = DB::table('user_password')->where('uid', $uuser->id)->update(array(
            'active' => false
        ));
        if (!$delete) return -1;

        $r = request();

        $insert = DB::table('user_password')->insert(array(
            'uid' => $uuser->id,
            'hash' => \App\Password::hash($pass, $user),
            'ip' => $r->ip(),
            'user-agent' => $r->server('HTTP_USER_AGENT'),
            'created' => time(),
            'active' => true
        ));
        if (!$insert) return -1;
        return 0;

    });

    Route::post('create_user', function(Request $r) {

        $data = json_decode($r->getContent());


        $created = \App\Account::make(array(
            'ip' => $data->ip,
            'useragent' => $data->userag,
            'appid' => $data->registrator,
            'login' => $data->login,
            'email' => $data->email,
            'password' => $data->password,
            'name' => $data->login,
        ));

        if ($created) return array('message' => 'User ' . $data->login . ' created successfully.');
        return array('message' => 'Error happened!');
    });


    Route::get('/suspend_app/{appid}', function (Request $r, int $appid) {
        $apps = DB::table('apps')->where('id', $appid)->get();
        if (count($apps) == 0) abort(400);
        $app = $apps[0];

        DB::table('apps')->where('id', $appid)->update(array('suspended' => !$app->suspended));
        return !$app->suspended;
    });

    Route::get('revoke_secret/{appid}', function (Request $r, int $appid) {
        $apps = DB::table('apps')->where('id', $appid)->get();
        if (count($apps) == 0) abort(400);
        $app = $apps[0];

        $new_secret = App\Secret::create('name', $app->name);
        DB::table('apps')->where('id', $appid)->update(array('secret' => $new_secret));
        return $new_secret;
    });

    Route::any('create_app', function (Request $r) {
        $user = DB::table('user_session')->where('key', $r->session()->get('user_session'))->get()[0];
        if ($user->user != 2) abort(401);

        $data = json_decode($r->getContent());

        $secret = \App\Secret::create($data->name, rand(1000, 9999));

        DB::table('apps')->insert(array(
            'name' => $data->name,
            'public_name' => $data->pubName,
            'contact' => $data->contact,
            'link' => $data->link,

            'secret' => $secret,
            'created' => time()
        ));

        return array(
            'success' => true,
            'secret' => $secret
        );
    });

});
