<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->foreignId('hotel_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('department_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('account_code_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('tax_applied_id')
                ->constrained()
                ->onDelete('cascade');
            $table->text('description')->nullable();
            $table->integer('adult_type');
            $table->integer('adult_child');
            $table->integer('included')->default(1);
            $table->integer('active')->default(1);
            $table->integer('sort_order')->default(0);
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
        Schema::dropIfExists('room_taxes');
    }
}
