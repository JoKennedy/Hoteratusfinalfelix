<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInclusionPackagesMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inclusion_packages_master', function (Blueprint $table) {
            $table->id();
            $table->foreignId('packages_master_id')
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
        Schema::dropIfExists('inclusion_packages_master');
    }
}
