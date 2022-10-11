<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_session', function(Blueprint $blue) {
            $blue->id('id');
            $blue->bigInteger('user');
            $blue->text('key');
            $blue->text('used_password');
            $blue->bigInteger('appid');
            $blue->bigInteger('lastAccess');
            $blue->string('ip', 45);
            $blue->string('user-agent');
            $blue->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_session');
    }
};
