<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('vendor_id')->unsigned()->index();
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('vehicle_type_id')->unsigned()->index();
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->onDelete('cascade');

            $table->integer('vehicle_category_id')->unsigned()->index();
            $table->foreign('vehicle_category_id')->references('id')->on('vehicle_categories')->onDelete('cascade');

            $table->string('registration_no');
            $table->string('registration_pic');
            $table->string('image');
            $table->string('owner_name');
            $table->string('owner_mobile');
            $table->text('owner_address1');
            $table->text('owner_address2');
            $table->string('owner_city');
            $table->string('owner_state');
            $table->string('owner_pincode');
            $table->text('parking_location');
            $table->boolean('gpsenabled')->default(false);
            $table->boolean('noentrypermit')->default(false);

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
        Schema::dropIfExists('vehicles');
    }
}
