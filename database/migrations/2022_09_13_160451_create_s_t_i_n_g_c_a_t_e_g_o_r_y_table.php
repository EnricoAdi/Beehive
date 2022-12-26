<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTINGCATEGORYTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sting_category', function (Blueprint $table) {
            $table->increments('ID_STINGCATEGORY');
            $table->string('ID_STING')->index();
            $table->integer('ID_CATEGORY')->index();
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
        Schema::dropIfExists('sting_category');
    }
}
