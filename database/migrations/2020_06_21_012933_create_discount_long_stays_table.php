<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountLongStaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_long_stays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
            ->constrained();
            $table->foreignId('user_id')
            ->constrained();
            $table->string('name');
            $table->integer('min_stay')->default(1);
            $table->integer('discount_type')->default(1);
            $table->decimal('value')->default(0);
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
        Schema::dropIfExists('discount_long_stays');
    }
}
