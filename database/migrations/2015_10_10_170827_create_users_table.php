<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('username')->nullable()->index();
            $table->string('password');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('guardian_contact')->nullable();
            $table->enum('id_proof_type' , ['adhar_card' , 'voter_id' , 'driving_license'])->nullable();
            $table->integer('id_doc_id')->unsigned()->nullable();
            $table->foreign('id_doc_id')->references('id')->on('uploaded_documents')->onDelete('cascade')->onUpdate('cascade');
            $table->string('phone')->nullable();
            $table->integer('center_id')->unsigned()->nullable();
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade')->onUpdate('cascade');
            $table->string('avatar')->nullable();
            $table->unsignedInteger('role_id')->default(2);
            $table->date('birthday')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('status', 20)->index();
            $table->integer('two_factor_country_code')->nullable();
            $table->bigInteger('two_factor_phone', false, true)->nullable();
            $table->text('two_factor_options')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
