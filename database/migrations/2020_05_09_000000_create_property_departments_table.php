<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
            ->nullable()
            ->constrained();
            $table->string('name');
            $table->string('code',45);
            $table->text('description')->nullable();
            $table->integer('editable')->default(0);
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
        Schema::dropIfExists('property_departments');
    }
}
