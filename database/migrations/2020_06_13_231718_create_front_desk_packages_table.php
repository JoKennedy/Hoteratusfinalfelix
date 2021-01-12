<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontDeskPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_desk_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreignId('user_id')
            ->constrained()
            ->onDelete('cascade');
            $table->string('name');
            $table->string('code');
            $table->text('description');
            $table->integer('stay_length');
            $table->integer('day_package')->default(0);
            $table->bigInteger('days_valid_id')->default(1);
            //package_weekdays
            $table->integer('update_price')->default(0);
            $table->integer('prorated')->default(0);
            $table->integer('inclusive_tax')->default(0);
            $table->integer('travel_agency')->default(0);
            $table->integer('publish_ta')->default(0);
            $table->decimal('travel_agent_commission',10,2)->default(0);
            $table->integer('travel_agent_commission_type')->default(1);
            $table->integer('corporate')->default(0);
            $table->decimal('corporate_discount', 10, 2)->default(0);
            $table->integer('validity')->default(1);
            $table->bigInteger('season_attribute')->default(0);
            $table->bigInteger('season_id')->default(0);
            $table->bigInteger('special_period_id')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('featured')->default(0);
            $table->integer('sort_order')->default(0);
            $table->integer('activated_forever')->default(0);
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
        Schema::dropIfExists('front_desk_packages');
    }
}
