<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->string('name')->nullable();
            $table->string('i18n')->nullable();
            $table->string('class')->nullable();
            $table->string('slug')->nullable();
            $table->string('icon')->nullable();
            $table->string('tag')->nullable();
            $table->string('tagcustom')->nullable();
            $table->integer('order1')->default(0);
            $table->integer('order2')->default(0);
            $table->integer('order3')->default(0);
            $table->integer('order4')->default(0);
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
        Schema::dropIfExists('menus');
    }
}
