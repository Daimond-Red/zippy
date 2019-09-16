<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->string('mobile_no');
            $table->string('image');
            $table->string('facebook_id');
            $table->string('gplus_id');
            $table->enum('signup_type', ['normal', 'facebook', 'gplus']);
            $table->string('locations');
            $table->string('device_id');
            $table->string('device_type');
            $table->text('device_token');
            $table->tinyInteger('role')->default(0);
            $table->boolean('status');
            $table->boolean('is_verified');
            $table->string('otp');
            $table->dateTime('otp_created_at');
            $table->rememberToken();
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
