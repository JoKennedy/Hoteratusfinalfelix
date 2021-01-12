<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTaxDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_tax_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_tax_id')
                ->constrained()
                ->onDelete('cascade')
                ->nullable();
            $table->date('activetion_date')->nullable();
            $table->decimal('charge_less', 14, 2)->nullable();
            $table->foreignId('account_code_id')
                ->nullable()
                ->constrained();
            $table->decimal('tax_value', 14, 2);
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
        Schema::dropIfExists('room_tax_details');
    }
}
