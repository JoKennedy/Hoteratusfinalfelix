<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreignId('user_id')
            ->constrained()
            ->onDelete('cascade');
            $table->string('name');
            $table->string('code');
            $table->integer('featured')->default(0);
            $table->foreignId('product_subcategory_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreignId('measurement_unit_id')
            ->constrained()
            ->onDelete('cascade');
            ///Price - Unidad
            ///Imagenes de PRoductos
            $table->text('description');
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
        Schema::dropIfExists('products');
    }
}
