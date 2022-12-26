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
        Schema::create('sting_complain_resolve', function (Blueprint $table) {
            $table->increments('ID_COMPLAIN');
            $table->string('ID_TRANSACTION');
            $table->text('COMPLAIN');
            $table->integer('TYPE')->comment("0 STING, 1 LELANG");
            $table->string('FILE_REVISION');
            $table->dateTime("CREATED_AT");
            $table->dateTime("UPDATED_AT");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sting_complain_resolve');
    }
};
