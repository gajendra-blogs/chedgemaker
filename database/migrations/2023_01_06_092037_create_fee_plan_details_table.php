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
        Schema::create('fee_plan_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fee_head_id')->unsigned();
            $table->foreign('fee_head_id')->references('id')->on('fee_heads')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('fee_plan_id')->unsigned();
            $table->foreign('fee_plan_id')->references('id')->on('fee_plans')->onDelete('cascade')->onUpdate('cascade');
            $table->string('amount');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unique(['fee_head_id', 'fee_plan_id']);
            $table->nullableTimestamps(0);
            $table->enum('status', array('0', '1'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_plan_details');
    }
};



