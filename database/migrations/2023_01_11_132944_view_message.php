<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ViewMessage extends Migration
{

    public function up()
    {
        Schema::create('view_message', function (Blueprint $table) {
            $table->increments('id');;
            $table->integer('personnel_id')->unsigned();
            $table->integer('reminder_id')->unsigned();
            $table->integer('status');
            $table->timestamps();

            $table->foreign('personnel_id')
                    ->references('id')
                    ->on('personnel')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('reminder_id')
                    ->references('id')
                    ->on('reminder')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('view_message');
    }
};
