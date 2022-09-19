<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('driver_id')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->string('own_vehicle_status');
            $table->string('owner_name');
            $table->string('name');
            $table->string('vehicle_code');
            $table->integer('brand_id');
            $table->integer('category_id');
            $table->string('rent_type')->nullable();
            $table->string('price')->nullable();
            $table->string('model')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('registration_date')->nullable();
            $table->string('chassis_no')->nullable();
            $table->string('engine_no')->nullable();
            $table->string('vehicle_class')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('fitness')->nullable();
            $table->string('rc_status')->nullable();
            $table->string('image')->nullable();
            $table->integer('status')->default(1);
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
