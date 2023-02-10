<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PersonnelSchedule extends Migration
{

    public function up()
    {
        Schema::create('personnel_schedule', function (Blueprint $table) {
            $table->increments('id');;
            $table->date('date');
            $table->integer('schedule_id')->unsigned();
            $table->integer('conductor_id');
            $table->integer('dispatcher_id');
            $table->integer('operator_id');
            $table->integer('bus_id')->unsigned();
            $table->integer('max_trips');
            $table->integer('status'); // 1 = Active, 2 = Not Active
            $table->timestamps();

            $table->foreign('schedule_id')
                    ->references('id')
                    ->on('schedule')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('bus_id')
                    ->references('id')
                    ->on('bus')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('personnel_schedule');
    }
};
