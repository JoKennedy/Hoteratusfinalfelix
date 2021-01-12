<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_extensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
            ->constrained()
            ->onDelete('cascade');
            $table->string('extension_number');
            $table->string('title')->nullable();
            $table->string('comments')->nullable();
            $table->foreignId('room_id')
            ->nullable()->constrained();
            $table->foreignId('property_department_id')
                ->nullable()->constrained();
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
        Schema::dropIfExists('phone_extensions');
    }
}
