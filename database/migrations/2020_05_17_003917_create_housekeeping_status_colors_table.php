<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHousekeepingStatusColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('housekeeping_status_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('housekeeping_status_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('color');
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
        Schema::dropIfExists('housekeeping_status_colors');
    }
}
