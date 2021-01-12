<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomPricePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_price_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
            ->constrained();
            $table->foreignId('room_price_id')
            ->constrained();
            $table->morphs('policyable');
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
        Schema::dropIfExists('room_price_policies');
    }
}
