<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUSERTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        date_default_timezone_set("Asia/Jakarta");
        $date = date("Y-m-d H:i:s");
        Schema::create('user', function (Blueprint $table) use($date) {
            $table->string('EMAIL')->primary();
            $table->string('PASSWORD');
            $table->string('NAMA');
            $table->string('REMEMBER_TOKEN')->unique();
            $table->integer('STATUS')->comment('1 = Farmer 2 = BeeWorker 3 = Admin 0 = Beeworker not verified -1 = Farmer not verified');
            $table->dateTime('TANGGAL_LAHIR');
            $table->decimal('BALANCE',15,2);
            $table->text('BIO');
            $table->decimal('RATING');
            $table->text('PICTURE');
            $table->integer('SUBSCRIBED')->comment('0 = Not Subscribed 1 = Subscribed ');
            $table->dateTime("EMAIL_VERIFIED_AT")->nullable();
            $table->dateTime("SUBSCRIBED_AT")->nullable();
            $table->dateTime("CREATED_AT")->default($date);
            $table->dateTime("UPDATED_AT")->default($date);
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
        Schema::dropIfExists('user');
    }
}
