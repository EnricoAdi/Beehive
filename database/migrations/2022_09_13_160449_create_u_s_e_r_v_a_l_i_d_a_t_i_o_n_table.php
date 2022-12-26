<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUSERVALIDATIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_validation', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('EMAIL')->index();
            $table->dateTime('EXP_DATE');
            $table->integer('STATUS')->comment('1=Verification, 2=Forgot Password');
            $table->string('TOKEN');
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
        Schema::dropIfExists('user_validation');
    }
}
