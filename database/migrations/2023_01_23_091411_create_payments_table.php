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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_registration_id')->unsigned();
            $table->foreign('user_registration_id')->references('id')->on('user_registrations')->onDelete('cascade')->onUpdate('cascade');
            $table->string('transaction_id');
            $table->string('payment_method');
            $table->string('amount');
            $table->string('description')->nullable();
            $table->string('wallet')->nullable();
            $table->string('entity')->nullable();
            $table->string('refund_Date')->nullable();
            $table->string('bank_transaction_id')->nullable();
            $table->string('bank')->nullable();
            $table->string('bank_check_date')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('payments');
    }
};
