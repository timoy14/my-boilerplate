<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('phone');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->enum('language', ['en', 'ar'])->default('ar');

            $table->integer('role_id')->unsigned();
            $table->integer('city_id')->unsigned()->default(1);
            $table->integer('gender_id')->unsigned()->default(1);
            $table->string('avatar')->nullable();
            $table->string('activation_code')->nullable();

            
            $table->string('address')->nullable(); 
            $table->string('latitude')->nullable(); 
            $table->string('longitude')->nullable(); 
            $table->string('bio')->nullable(); 
         
            $table->string('id_number')->nullable();
            $table->string('valid_id_picture')->nullable();

            

            $table->string('bank_name')->nullable();
            $table->string('bank_account_num')->nullable();

            $table->boolean('agreement_verify')->default(0);
            $table->boolean('is_verified')->default(0);

            $table->text('api_token')->nullable();
            $table->string('exponent_token')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}