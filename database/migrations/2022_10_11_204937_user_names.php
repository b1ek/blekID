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
        Schema::create('user_names', function (Blueprint $blue) {
            $blue->id('id');
            $blue->bigInteger('uid');
            $blue->text('name');
            $blue->string('ip', 45)->nullable();
            $blue->text('user-agent')->nullable();
            $blue->boolean('active')->default('true');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_names');
    }
};
