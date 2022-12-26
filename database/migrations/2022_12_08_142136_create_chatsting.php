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
        Schema::create('chat_sting', function (Blueprint $table) {
            $table->increments('ID_CHAT');
            $table->string('ID_TRANSACTION');
            $table->string('EMAIL');
            $table->text('BODY');
            $table->integer('TYPE')->comment('1 = Beeworker, 0 Farmer');
            $table->integer('ID_COMPLAIN')->nullable(true);
            $table->integer('REPLY_TO')->nullable(true);
            $table->dateTime("CREATED_AT");
            $table->dateTime("UPDATED_AT");
            $table->dateTime("DELETED_AT")->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_sting');
    }
};
