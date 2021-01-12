<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesMasterRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages_master_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('packages_master_id')
            ->constrained();
            $table->foreignId('room_type_id')
            ->constrained();
            $table->foreignId('user_id')
                ->constrained();
            $table->decimal('base_price', 10, 2);
            $table->decimal('extra_person', 10, 2);
            $table->decimal('extra_bed', 10, 2);
            $table->integer('adults_minimum');
            $table->integer('children_minimum');
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
        Schema::dropIfExists('packages_master_rooms');
    }
}
