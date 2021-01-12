<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesMasterUpchargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages_master_upcharges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('packages_master_room_id')
            ->constrained();
            $table->foreignId('user_id')
            ->constrained();
            $table->integer('persons');
            $table->decimal('adults',10,2);
            $table->decimal('children', 10, 2);
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
        Schema::dropIfExists('packages_master_upcharges');
    }
}
