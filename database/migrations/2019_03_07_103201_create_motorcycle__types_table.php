<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotorcycleTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motorcycle_types', function (Blueprint $table) {
            $table->increments('id_motorcycle_type');
            $table->string('motorcycle_type_name',50);
            $table->integer('id_motorcycle_brand')->unsigned();
            $table->foreign('id_motorcycle_brand')->references('id_motorcycle_brand')->on('motorcycle_brands')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('motorcycle__types');
    }
}
