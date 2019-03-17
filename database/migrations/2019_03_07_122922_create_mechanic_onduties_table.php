<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMechanicOndutiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mechanic_onduties', function (Blueprint $table) {
            $table->increments('id_mechanic_onduty');
            $table->integer('id_employee')->unsigned();
            $table->foreign('id_employee')->references('id_employee')->on('employees')->onUpdate('cascade');
            $table->integer('id_motorcycle')->unsigned();
            $table->foreign('id_motorcycle')->references('id_motorcycle')->on('motorcycles')->onUpdate('cascade');
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
        Schema::dropIfExists('mechanic_onduties');
    }
}
