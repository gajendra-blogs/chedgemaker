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
        Schema::create('student_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('type' , ['home' , 'work']);
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->integer('country')->unsigned();
            $table->foreign('country')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('state')->unsigned();
            $table->foreign('state')->references('id')->on('states')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('city')->unsigned();
            $table->foreign('city')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->string('pin_code');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_addresses');
    }
};
