<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompatibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compatibilities', function (Blueprint $table) {
            $table->increments('id_compatibility');
            $table->integer('id_motorcycle_type')->unsigned();
            $table->foreign('id_motorcycle_type')->references('id_motorcycle_type')->on('motorcycle_types')->onUpdate('cascade')->onDelete('cascade');
            $table->string('id_sparepart');
            $table->foreign('id_sparepart')->references('id_sparepart')->on('spareparts')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('compatibilities');
    }
}
