<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Reminder extends Migration
{

    public function up()
    {
        Schema::create('reminder', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('subject');
            $table->string('message');
            $table->string('user_type'); // Passengers, Operator, Conductor, Dispatcher
            $table->timestamps();

            $table->foreign('company_id')
                    ->references('id')
                    ->on('company')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reminder');
    }
};
