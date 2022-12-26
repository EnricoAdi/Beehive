<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLELANGSTINGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lelang_sting', function (Blueprint $table) {
            $table->string('ID_LELANG_STING')->primary();
            $table->text('REQUIREMENT_PROJECT');
            $table->string('TITLE_STING');
            $table->string('EMAIL_FARMER');
            $table->string('EMAIL_BEEWORKER')->nullable(true);
            $table->integer('STATUS')->comment("-1 = Deleted 0 = Pending  1 = Accepted by beeworker/seller   2 = Done Work ");
            $table->decimal('COMMISION',15,2);
            $table->decimal('TAX',15,2);
            $table->string('FILENAME_FINAL');
            $table->integer('RATE');
            $table->text('REVIEW');
            $table->dateTime("DATE_START")->nullable(true);
            $table->dateTime("DATE_END")->nullable(true);
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
        Schema::dropIfExists('lelang_sting');
    }
}
