<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcurementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procurement_details', function (Blueprint $table) {
            $table->increments('id_procurement_detail');
            $table->double('price');
            $table->double('subtotal');
            $table->integer('amount');
            $table->integer('id_procurement')->unsigned();
            $table->foreign('id_procurement')->references('id_procurement')->on('procurements')->onUpdate('cascade')->onDelete('cascade');
            $table->string('id_sparepart',30);
            $table->foreign('id_sparepart')->references('id_sparepart')->on('spareparts')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procurement_details');
    }
}
