<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->integer('fee_plan_id')->unsigned();
            $table->foreign('fee_plan_id')->references('id')->on('fee_plans')->onDelete('cascade')->onUpdate('cascade');
            $table->string('installment_amount')->default('0');
            $table->string('due_time')->nullable();
            $table->integer('status')->default(0);
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('u  pdated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->nullableTimestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('installments');
    }
};
