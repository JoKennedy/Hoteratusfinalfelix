<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     create table `reservation` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(191) not null, `phone` varchar(191) not null, `email` varchar(191) not null, `fecha_entrda` varchar(191) not null, `fecha_salida` varchar(191) not null, `address` varchar(191) not null, `country` varchar(191) not null, `gender` varchar(191) not null, `nationality` varchar(191) not null, `state` varchar(191) not null, `zip_code` int not null, `tim` varchar(191) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('fecha_entrda');
            $table->string('fecha_salida');
            $table->string('address');
            $table->string('country');
            $table->string('gender');
            $table->string('nationality');
            $table->string('state');
            $table->integer('zip_code');
            $table->string('tim');
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
        Schema::dropIfExists('reservation');
    }
}
