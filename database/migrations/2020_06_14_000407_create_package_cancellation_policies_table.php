<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageCancellationPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_cancellation_policies', function (Blueprint $table) {
            $table->id();
            $table->string("cancellationable_type");
            $table->unsignedBigInteger("cancellationable_id");
            $table->index(["cancellationable_type", "cancellationable_id"], 'pc_index');
            $table->foreignId('cancellation_policy_id')
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
        Schema::dropIfExists('package_cancellation_policies');
    }
}
