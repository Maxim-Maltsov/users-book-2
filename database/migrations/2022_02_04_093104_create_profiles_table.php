<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('job')->nullable();
            $table->string('status')->nullable();
            $table->string('avatar')->nullable();
            $table->string('vk')->nullable();
            $table->string('telegram')->nullable();
            $table->string('instagram')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
