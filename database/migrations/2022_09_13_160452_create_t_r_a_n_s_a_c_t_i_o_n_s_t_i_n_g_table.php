<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTRANSACTIONSTINGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_sting', function (Blueprint $table) {
            $table->string('ID_TRANSACTION')->primary();
            $table->string('ID_STING')->index();
            $table->string('EMAIL_FARMER')->index();
            $table->text('REQUIREMENT_PROJECT');
            $table->dateTime('DATE_START')->nullable();
            $table->dateTime('DATE_END')->nullable();
            $table->integer('STATUS')->comment('-2 = Canceled oleh farmer/buyer
            -1 = Rejected oleh beeworker/seller 0 = Pending 1 = Diterima 2 = Sedang Revisi 3 = Selesai ');
            $table->integer('IS_PREMIUM')->comment('0');
            $table->decimal('COMMISION',12,2);
            $table->decimal('TAX',12,2);
            $table->string('FILENAME_FINAL');
            $table->integer('RATE');
            $table->text('REVIEW');
            $table->integer('JUMLAH_REVISI');
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
        Schema::dropIfExists('transaction_sting');
    }
}
