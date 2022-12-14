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
        $path = base_path() . '/secret.txt';
        $secret = App\Secret::create('blek_id', 1);

        try {unlink($path);}
        catch (Exception) {}
        file_put_contents($path, $secret);

        DB::table('apps')->insert(array(
            'name' => 'blek_id',
            'public_name' => 'blek! ID',
            'created' => time(),
            'secret' => $secret,
            'contact' => 'me@blek.codes',
            'link' => 'id.blek.codes'
        ));
        /*DB::table('app_option')->insert(array(
            'appid' => 1,
            'key' => 'reg_disabled',
            'value' => 'true'
        ));*/
        DB::table('app_redirect')->insert(array(
            'appid' => 1,
            'link' => '/admin',
            'id' => 'success',
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('apps')->where('name', 'blek_id')->where('public_name', 'blek! ID')->where('id', 1)->delete();
    }
};
