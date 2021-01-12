<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
            ->constrained();
            $table->foreignId('hotel_id')
            ->constrained();
            $table->string('name');
            $table->string('code');
            $table->foreignId('property_department_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreignId('account_code_id')
            ->constrained()
            ->onDelete('cascade');
            $table->string('logo',500)->nullable();
            //Imagenes
            $table->string('company_name')->nullable();
            $table->string('company_address', 500)->nullable();
            $table->string('task_emails', 1000)->nullable();
            ///printer configurations
            $table->string('description', 500)->nullable();
            $table->foreignId('pos_type_id')
            ->constrained()
            ->onDelete('cascade'); // Restaurant / Pos/ Spa
            $table->integer('table_required')->default(0);
            $table->decimal('length',10,2)->default(0);
            $table->decimal('breadth', 10, 2)->default(0);
            $table->integer('product_required')->default(0);
            // TAxes Aplicables

            //Taxes Tips

            $table->integer('active')->default(0);
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
        Schema::dropIfExists('pos_points');
    }
}
