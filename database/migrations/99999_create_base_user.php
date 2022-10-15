<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create null user
        DB::table('users')->insert(array(
            'registrator' => 0,
            'login' => 'NULL',
            'email' => 'NULL',
            'ip' => '0.0.0.0',
            'user-agent' => '',
            'created' => 0,
            'deleted' => 0,
            'frozen' => true
        ));

        DB::table('user_session')->insert(array(
            'uid' => 1,
            'key' => Str::random(512),
            'used_password' => '',
            'appid' => 0,
            'lastAccess' => 0,
            'ip' => '0.0.0.0',
            'user-agent' => '',
            'active' => false
        ));



        $ua = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36';
        DB::table('users')->insert(array(
            'registrator' => 1,
            'login' => ENV('ADMIN_LOGIN'),
            'email' => ENV('ADMIN_MAIL'),
            'ip' => '0.0.0.0',
            'user-agent' => $ua,
            'created' => time(),
            'deleted' => 0
        ));
        DB::table('user_password')->insert(array(
            'uid' => 2,
            'hash' => \App\Password::hash(hash('sha512', ENV('ADMIN_PASSWORD')), ENV('ADMIN_LOGIN')),
            'ip' => '0.0.0.0',
            'user-agent' => $ua,
            'created' => time(),
            'active' => true
        ));
        // make this user an app's admin
        DB::table('app_option')->insert(array(
            'appid' => 2,
            'key' => 'admin',
            'value' => '1'
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->where('id', 1)->delete();
        DB::table('user_password')->where('uid', 1)->delete();
    }
};
