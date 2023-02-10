<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Discount extends Migration
{

    public function up()
    {
        Schema::create('discount', function (Blueprint $table) {
            $table->increments('id');
            $table->string('passenger_type'); // Student, Senior, Disability
            $table->float('discount');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discount');
    }
};
