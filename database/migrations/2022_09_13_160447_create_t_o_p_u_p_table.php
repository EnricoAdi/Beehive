<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTOPUPTable extends Migration
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
        Schema::create('top_up', function (Blueprint $table) use($date) {
            $table->string('KODE_TOPUP')->primary();
            $table->string('EMAIL')->index();
            $table->integer('CREDIT');
            $table->integer('PAYMENT_STATUS')->comment("-1 =Rejected
            0 = Pending
            1 = Accepted");
            $table->string('SNAP_TOKEN', 36)->nullable();
            $table->dateTime("CREATED_AT")->default($date);
            $table->dateTime("UPDATED_AT")->default($date);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('top_up');
    }
}
