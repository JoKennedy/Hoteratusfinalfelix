<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemoTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('user_reservation');
            $table->string('fecha_entrada_usuerio');
            $table->string('fecha_salida_usuerio');
            $table->string('habitacion');
            $table->string('costo_habitacion');
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
        Schema::dropIfExists('demo_tasks');
    }
}
