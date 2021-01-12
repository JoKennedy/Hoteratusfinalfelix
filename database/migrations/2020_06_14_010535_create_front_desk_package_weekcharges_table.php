<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontDeskPackageWeekchargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_desk_package_weekcharges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('front_desk_package_room_id');
            $table->foreign('front_desk_package_room_id', 'fdp_fdproom_id_foreign')->references('id')->on('front_desk_package_rooms');
            $table->foreignId('user_id')
            ->constrained();
            $table->integer('week_day'); //Lunes 1
            $table->decimal('charge', 10, 2);
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
        Schema::dropIfExists('front_desk_package_weekcharges');
    }
}
