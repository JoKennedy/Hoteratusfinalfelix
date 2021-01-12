<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
                ->constrained()
                ->nullable();
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->integer('base_occupancy');
            $table->integer('higher_occupancy')->nullable();
            $table->integer('exta_bed_allowed')->default(0);
            $table->integer('exta_bed_allowed_total')->default(0);
            $table->decimal('base_price', 14, 2);
            $table->decimal('higher_price', 14, 2);
            $table->decimal('extra_bed_price', 14, 2);
            $table->integer('sort_order')->default(0);
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
        Schema::dropIfExists('room_types');
    }
}
