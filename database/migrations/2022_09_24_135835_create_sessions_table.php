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
        Schema::create('sessions', function (Blueprint $blue) {
            $blue->string('id')->primary();
            $blue->foreignId('user_id')->nullable()->index();
            $blue->string('ip_address', 45)->nullable();
            $blue->string('locale');
            $blue->bigInteger('account_id');
            $blue->bigInteger('created');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
};
