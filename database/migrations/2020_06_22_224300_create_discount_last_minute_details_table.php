<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountLastMinuteDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_last_minute_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discount_last_minute_id')
            ->constrained();
            $table->foreignId('user_id')
            ->constrained();
            $table->integer('start')->default(1);
            $table->integer('end')->default(1);
            $table->decimal('start_percentage')->default(0);
            $table->decimal('end_percentage')->default(0);
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
        Schema::dropIfExists('discount_last_minute_details');
    }
}
