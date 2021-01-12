<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('logo')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->foreignId('country_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('website_address')->nullable();
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->text('description_service')->nullable();
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
        Schema::dropIfExists('hotels');
    }
}
