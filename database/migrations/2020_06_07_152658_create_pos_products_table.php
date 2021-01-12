<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreignId('pos_point_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreignId('product_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreignId('account_code_id')
            ->nullable()
            ->constrained();
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
        Schema::dropIfExists('pos_products');
    }
}
