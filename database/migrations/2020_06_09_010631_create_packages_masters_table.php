<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages_masters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
            ->constrained();
            $table->foreignId('user_id')
            ->constrained();
            $table->string('name');
            $table->string('code');
            $table->string('stay_length');
            $table->text('description');
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
        Schema::dropIfExists('packages_masters');
    }
}
