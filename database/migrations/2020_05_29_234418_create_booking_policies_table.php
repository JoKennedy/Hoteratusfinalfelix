<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
            ->constrained();
            $table->foreignId('hotel_id')
            ->constrained();
            $table->string('name');
            $table->integer('before')->nullable();
            $table->integer('before_type')->default(1);
            $table->foreignId('web_policy_type_id')
            ->constrained();
            $table->decimal('charge', 10, 2)->nullable();
            $table->integer('charge_type_id')->default(1);
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
        Schema::dropIfExists('booking_policies');
    }
}
