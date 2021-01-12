<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salutation_id')
                ->nullable()
                ->constrained();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('phone')->nullable();
            $table->string('extension')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->morphs('contactable');
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
        Schema::dropIfExists('billing_contacts');
    }
}
