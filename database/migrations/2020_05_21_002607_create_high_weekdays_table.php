<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHighWeekdaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('high_weekdays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('default_setting_id')
                ->constrained()
                ->onDelete('cascade');
            $table->integer('monday')->default(0);
            $table->integer('tuesday')->default(0);
            $table->integer('wednesday')->default(0);
            $table->integer('thursday')->default(0);
            $table->integer('friday')->default(0);
            $table->integer('saturday')->default(0);
            $table->integer('sunday')->default(0);
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
        Schema::dropIfExists('high_weekdays');
    }
}
