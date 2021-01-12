<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInclusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inclusions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
            ->constrained();
            $table->foreignId('user_id')
            ->constrained();
            $table->string('name');
            $table->string('code');
            $table->text('description');
            $table->foreignId('pos_product_id')
            ->constrained()
            ->onDelete('cascade');
            $table->decimal('price', 10,2)->default(0);
            $table->integer('update_price')->default(1);
            $table->decimal('discount', 10, 2)->default(0);
            $table->integer('discount_type')->default(1); //1 Dinero 2 Porciento
            $table->foreignId('calculation_rule_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreignId('posting_rhythm_id')
            ->constrained()
            ->onDelete('cascade');
            $table->integer('public_web')->default(0);

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
        Schema::dropIfExists('inclusions');
    }
}
