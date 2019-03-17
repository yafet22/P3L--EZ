<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_services', function (Blueprint $table) {
            $table->increments('id_detail_service');
            $table->integer('detail_service_amount');
            $table->double('detail_service_price');
            $table->double('detail_service_subtotal');
            $table->string('id_transaction',30);
            $table->foreign('id_transaction')->references('id_transaction')->on('transactions')->onUpdate('cascade');
            $table->integer('id_service')->unsigned();
            $table->foreign('id_service')->references('id_service')->on('services')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('id_mechanic_onduty')->unsigned()->nullable();
            $table->foreign('id_mechanic_onduty')->references('id_mechanic_onduty')->on('mechanic_onduties')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('detail_services');
    }
}
