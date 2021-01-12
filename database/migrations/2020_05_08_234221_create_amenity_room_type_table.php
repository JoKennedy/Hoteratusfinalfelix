<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmenityRoomTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amenity_room_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('amenity_id')
                ->constrained()
                ->onDelete('cascade')
                ->nullable();
            $table->foreignId('room_type_id')
                ->constrained()
                ->onDelete('cascade')
                ->nullable();
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
        Schema::dropIfExists('amenity_room_type');
    }
}
