<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Fare extends Migration
{

    public function up()
    {
        Schema::create('fare', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('route_id')->unsigned();
            $table->integer('bus_type'); // 1 = Aircon, 2 = Non-aircon
            $table->float('price');
            $table->timestamps();

            $table->foreign('route_id')
                    ->references('id')
                    ->on('route')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fare');
    }
};
