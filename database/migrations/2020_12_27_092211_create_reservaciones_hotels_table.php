<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



class CreateReservacionesHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservaciones_hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_reservation');
            $table->string('fecha_entrada_usuerio');
            $table->string('fecha_salida_usuerio');
            $table->string('habitacion');
            $table->string('costo_habitacion');
            $table->string('created_at');
            $table->string('updated_at');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservaciones_hotels');
    }
}
