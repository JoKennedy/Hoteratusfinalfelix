<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
                ->constrained();
            $table->foreignId('property_department_id')
                ->constrained();
            $table->string('name');
            $table->string('code',10);
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
        Schema::dropIfExists('account_codes');
    }
}
