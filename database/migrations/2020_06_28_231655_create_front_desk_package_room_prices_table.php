<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontDeskPackageRoomPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_desk_package_room_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("front_desk_package_room_id");
            $table->foreign('front_desk_package_room_id', 'front_desk_package_room_id_foreign')->references('id')->on('front_desk_package_rooms');
            $table->foreignId('user_id')
            ->constrained();
            $table->decimal('base_price',10,2);
            $table->decimal('extra_person', 10, 2);
            $table->decimal('extra_bed', 10, 2);
            $table->integer('adults_minimum')->default(0);
            $table->integer('children_minimum')->default(0);
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
        Schema::dropIfExists('front_desk_package_room_prices');
    }
}
