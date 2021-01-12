<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontDeskPackageActivationDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_desk_package_activation_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('front_desk_package_id');
            $table->foreign('front_desk_package_id', 'fdp_fdpd_id_foreign')->references('id')->on('front_desk_packages');
            $table->date('start');
            $table->date('end');
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
        Schema::dropIfExists('front_desk_package_activation_dates');
    }
}
