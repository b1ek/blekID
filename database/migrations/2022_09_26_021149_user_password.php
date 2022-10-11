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
        Schema::create('user_password', function(Blueprint $blue) {
            $blue->id('id');
            $blue->bigInteger('uid');
            $blue->text('hash');
            $blue->string('ip', 45);
            $blue->string('user-agent');
            $blue->bigInteger('created');
            $blue->boolean('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_password');
    }
};
