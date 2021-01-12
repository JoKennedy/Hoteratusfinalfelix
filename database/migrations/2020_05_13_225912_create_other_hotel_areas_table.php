<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherHotelAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_hotel_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
            ->constrained()
            ->onDelete('cascade');

            $table->foreignId('floor_id')
                ->nullable()
                ->constrained();
            $table->foreignId('block_id')
                ->nullable()
                ->constrained();
            $table->string('name');
            $table->string('description');
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('other_hotel_areas');
    }
}
