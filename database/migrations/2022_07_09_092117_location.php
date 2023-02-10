<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Location extends Migration
{

    public function up()
    {
        Schema::create('location', function (Blueprint $table) {
            $table->increments('id');
            $table->string('place')->unique();
            $table->decimal('latitude', 8,6);
            $table->decimal('longitude', 9,6);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('location');
    }
};
