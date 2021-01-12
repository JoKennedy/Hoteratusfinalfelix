<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DevelopersTaskDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->integer('active')->default(1);
            $table->integer('company_id')
            ->nullable();
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')
            ->constrained()
            ->onDelete('cascade');
            $table->string('subject');
            $table->string('description');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('company_id');
            $table->string('usernote')->nullable();;
            $table->integer('developer_id');
            $table->integer('status_id');
            $table->timestamps();
        });
        Schema::create('tasks_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->integer('company_id');
            $table->timestamps();
        });

        Schema::create('tasks_sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->integer('company_id')->nullable();;
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
        Schema::dropIfExists('developers');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('tasks_categories');
        Schema::dropIfExists('tasks_sub_categories');
    }
}
