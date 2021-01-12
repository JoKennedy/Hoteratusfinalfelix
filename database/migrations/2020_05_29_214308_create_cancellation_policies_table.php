<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancellationPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancellation_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
            ->constrained();
            $table->foreignId('hotel_id')
            ->constrained();
            $table->string('name');
            $table->integer('before')->nullable();
            $table->integer('before_type')->default(1);
            $table->decimal('charge',10,2)->default(0);
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
        Schema::dropIfExists('cancellation_policies');
    }
}
