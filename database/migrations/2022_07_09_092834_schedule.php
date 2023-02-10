<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Schedule extends Migration
{

    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('route_id')->unsigned()->unique();
            $table->time('first_trip');
            $table->time('last_trip');
            $table->integer('interval_mins');
            $table->integer('status'); // 1 = Active, 2 = Inactive
            $table->timestamps();

            $table->foreign('company_id')
                    ->references('id')
                    ->on('company')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

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
        Schema::dropIfExists('schedule');
    }
};
