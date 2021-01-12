<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageBookingPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_booking_policies', function (Blueprint $table) {
            $table->id();
            $table->string("bookingable_type");
            $table->unsignedBigInteger("bookingable_id");
            $table->index(["bookingable_type", "bookingable_id"], 'pb_index');
            $table->foreignId('booking_policy_id')
            ->constrained();
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
        Schema::dropIfExists('package_booking_policies');
    }
}
