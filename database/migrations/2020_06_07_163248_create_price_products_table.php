<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_products', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreignId('pos_product_id')
            ->constrained()
            ->onDelete('cascade');
            $table->decimal('price',10,2)->default(0);
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
        Schema::dropIfExists('price_products');
    }
}
