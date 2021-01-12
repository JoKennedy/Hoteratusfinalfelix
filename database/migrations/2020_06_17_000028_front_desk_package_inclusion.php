<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FrontDeskPackageInclusion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_desk_package_inclusion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('front_desk_package_id')
            ->constrained();
            $table->foreignId('inclusion_id')
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
        Schema::dropIfExists('front_desk_package_inclusion');
    }
}
