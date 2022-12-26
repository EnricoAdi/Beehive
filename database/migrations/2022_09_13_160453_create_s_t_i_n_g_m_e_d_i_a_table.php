<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTINGMEDIATable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sting_media', function (Blueprint $table) {
            $table->increments('ID_STING_MEDIA');
            $table->string('ID_STING')->index();
            $table->string('FILENAME');
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
        Schema::dropIfExists('sting_media');
    }
}
