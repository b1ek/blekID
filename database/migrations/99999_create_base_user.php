<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ua = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36';
        DB::table('users')
            ->insert(array(
                'registrator' => 1,
                'login' => 'blek!',
                'ip' => '0.0.0.0',
                'user-agent' => $ua,
                'created' => time(),
                'deleted' => 0
            ));
        DB::table('user_password')
            ->insert(array(
                'uid' => 1,
                'hash' => \App\Password::hash(hash('sha512', '123'), 'blek!'),
                'ip' => '0.0.0.0',
                'user-agent' => $ua,
                'created' => time(),
                'active' => true
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
