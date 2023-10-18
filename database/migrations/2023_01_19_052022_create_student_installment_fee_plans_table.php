<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_installment_fee_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_registration_id')->unsigned();
            $table->foreign('user_registration_id')->references('id')->on('user_registrations')->onDelete('cascade')->onUpdate('cascade');
            $table->string('installment_amount')->default('0');
            $table->string('due_time')->nullable();
            $table->string('paid_amount');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->enum('status', array('pending', 'paid'))->default('pending');
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
        Schema::dropIfExists('student_installment_fee_plans');
    }
};