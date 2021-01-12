<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->foreignId('hotel_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('room_type_id')
                ->constrained();
            $table->foreignId('floor_id')
                ->nullable()
                ->constrained();
            $table->foreignId('block_id')
                ->nullable()
                ->constrained();
            $table->text('description')->nullable();
            $table->integer('sort_order')->dafault(0);
            $table->integer('active')->default();
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
        Schema::dropIfExists('rooms');
    }
}
