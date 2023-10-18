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
        Schema::create('emails_queues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from_mail');
            $table->string('to_mail');
            $table->string('cc_mail')->nullable();
            $table->string('bcc_mail')->nullable();
            $table->string('subject');
            $table->string('attachment')->nullable();
            $table->text('body');
            $table->enum('priority' , array('normal' , 'high' , 'medium'))->default('normal');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status' , array('sent' , 'pending' , 'failed'))->default('pending');
            $table->string('failed_message')->nullable();
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
        Schema::dropIfExists('emails_queues');
    }
};
