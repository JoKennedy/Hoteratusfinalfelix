<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('name');
            $table->foreignId('season_attribute_id')
                ->constrained()
                ->onDelete('cascade');
            $table->date('start');
            $table->date('end');
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
        Schema::dropIfExists('special_periods');
    }
}
