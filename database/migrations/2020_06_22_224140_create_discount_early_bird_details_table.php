<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountEarlyBirdDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_early_bird_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discount_early_bird_id')
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
        Schema::dropIfExists('discount_early_bird_details');
    }
}
