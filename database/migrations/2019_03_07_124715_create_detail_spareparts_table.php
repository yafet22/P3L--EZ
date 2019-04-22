<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailSparepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_spareparts', function (Blueprint $table) {
            $table->increments('id_detail_sparepart');
            $table->integer('detail_sparepart_amount');
            $table->double('detail_sparepart_price');
            $table->double('detail_sparepart_subtotal');
            $table->string('id_transaction',30);
            $table->foreign('id_transaction')->references('id_transaction')->on('transactions')->onUpdate('cascade')->onDelete('cascade');
            $table->string('id_sparepart',30);
            $table->foreign('id_sparepart')->references('id_sparepart')->on('spareparts')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('id_employee')->unsigned()->nullable();
            $table->foreign('id_employee')->references('id_employee')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('id_motorcycle')->unsigned()->nullable();
            $table->foreign('id_motorcycle')->references('id_motorcycle')->on('motorcycles')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('detail_spareparts');
    }
}
