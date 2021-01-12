<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
            ->constrained();
            $table->morphs('priceable');
            $table->foreignId('room_type_id')
                ->constrained();
            $table->decimal('base_occupancy',10,2)->default(0);
            $table->decimal('extra_person',10,2)->default(0);
            $table->decimal('extra_bed',10,2)->default(0);
            $table->decimal('base_occupancy_high', 10, 2)->default(0);
            $table->decimal('extra_person_high', 10, 2)->default(0);
            $table->decimal('extra_bed_high', 10, 2)->default(0);
            $table->integer('web')->defaultt(0);
            $table->integer('corp')->defaultt(0);
            $table->integer('agent')->defaultt(0);
            $table->foreignId('web_policy_type_id')
                    ->nullable()
                    ->constrained();
            $table->decimal('deposit_amount', 10, 2)->default(0);
            $table->integer('deposit_type')->default(1);
            $table->integer('value_type')->default(1);

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
        Schema::dropIfExists('room_prices');
    }
}
