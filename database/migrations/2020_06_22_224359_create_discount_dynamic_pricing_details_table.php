<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountDynamicPricingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_dynamic_pricing_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("discount_dynamic_pricing_id");
            $table->foreign('discount_dynamic_pricing_id', 'fdp_fdpd_id_foreign_discount')->references('id')->on('discount_dynamic_pricings');
            $table->foreignId('user_id')
            ->constrained();
            $table->integer('start_occupancy')->default(0);
            $table->integer('end_occupancy')->default(0);
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
        Schema::dropIfExists('discount_dynamic_pricing_details');
    }
}
