<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Trip extends Migration
{

    public function up()
    {
        Schema::create('trip', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('personnel_schedule_id')->unsigned();
            $table->integer('personnel_id')->unsigned();
            $table->integer('inverse');
            $table->integer('trip_no');
            $table->float('trip_duration');
            $table->integer('arrived');
            $table->string('departure')->nullable(); 
            $table->float('distance')->nullable();
            $table->timestamps();

            $table->foreign('personnel_schedule_id')
                    ->references('id')
                    ->on('personnel_schedule')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('personnel_id')
                    ->references('id')
                    ->on('personnel')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('trip');
    }
};
