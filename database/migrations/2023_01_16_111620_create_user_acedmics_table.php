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
        Schema::create('user_acedmics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('qualification', ['10', '12', 'graduation', 'post_graduation']);
            $table->string('institute')->nullable();
            $table->string('university')->nullable();
            $table->string('passout_year')->nullable();
            $table->string('place')->nullable();
            $table->integer('marks')->nullable();
            $table->integer('certificate_id')->unsigned()->nullable();
            $table->foreign('certificate_id')->references('id')->on('uploaded_documents')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('created_by')->unsigned()->nullable();
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
        Schema::dropIfExists('user_acedmics');
    }
};