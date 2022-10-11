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
        Schema::create('users', function(Blueprint $blue) {
            $blue->id('id');
            $blue->bigInteger('registrator');
            $blue->string('login');
            $blue->string('ip', 45);
            $blue->string('user-agent');
            $blue->bigInteger('created');
            // Timestamp when (if) the account was deleted
            // If its not, should be set to 0
            $blue->bigInteger('deleted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
