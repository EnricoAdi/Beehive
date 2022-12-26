<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTINGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sting', function (Blueprint $table) {
            $table->string('ID_STING')->primary();
            $table->text('DESKRIPSI');
            $table->string('TITLE_STING');
            $table->string('EMAIL_BEEWORKER')->index();
            $table->string('NAMA_THUMBNAIL');
            $table->decimal('RATING');
            $table->text('DESKRIPSI_BASIC');
            $table->text('DESKRIPSI_PREMIUM');
            $table->integer('PRICE_BASIC');
            $table->integer('PRICE_PREMIUM');
            $table->integer('MAX_REVISION_BASIC');
            $table->integer('MAX_REVISION_PREMIUM');
            $table->integer('STATUS')->comment('1');
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
        Schema::dropIfExists('sting');
    }
}
