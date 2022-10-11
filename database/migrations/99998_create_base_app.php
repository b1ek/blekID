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
        $secret = App\Secret::create('name', 1);

        try {unlink($path);}
        catch (Exception) {}
        file_put_contents($path, $secret);

        DB::table('apps')->insert(array(
            'name' => 'blek_id',
            'public_name' => 'blek! ID',
            'created' => time(),
            'secret' => $secret
        ));
        DB::table('app_redirect')->insert(array(
            'appid' => 1,
            'link' => ENV('APP_DEBUG', false) ? 'local.blek.codes:10084/auth/1' : 'id.blek.codes/auth/1',
            'id' => 'success'
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
