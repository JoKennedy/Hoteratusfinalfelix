<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlphabetCodingHotels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alphabet_coding_hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
            ->constrained();
            $table->foreignId('alphabet_coding_id')
            ->constrained();
            $table->string('code')->nullable();
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
        Schema::dropIfExists('alphabet_coding_hotels');
    }
}
