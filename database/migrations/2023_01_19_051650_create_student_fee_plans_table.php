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
        Schema::create('student_fee_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('fee_type' , array('lumpsum' , 'installment'));
            $table->string('total_fee');
            $table->string('name')->nullable();
            $table->string('discount')->nullable();
            $table->string('final_payable_amount');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');
            $table->integer('center_id')->unsigned();
            $table->foreign('center_id')->references('id')->on('centers');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
            $table->enum('status' , array('pending' , 'paid'))->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_fee_plans');
    }
};
