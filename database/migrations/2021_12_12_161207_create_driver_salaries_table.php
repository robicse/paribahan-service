<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_salaries', function (Blueprint $table) {
            $table->id();
            $table->integer('driver_id');
            $table->string('invoice_no')->nullable();
            $table->string('year')->nullable();
            $table->string('month')->nullable();
            $table->integer('payment_type_id');
            $table->float('salary', 8,2)->default(0);
            $table->float('paid', 8,2)->default(0);
            $table->float('due', 8,2)->default(0);
            $table->string('date')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('driver_salaries');
    }
}
