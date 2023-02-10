<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Position extends Migration
{

    public function up()
    {
        Schema::create('position', function (Blueprint $table) {
            $table->id();
            $table->integer('bus_id')->unsigned();
            $table->float('latitude', 10,8);
            $table->float('longitude', 11,8);
            $table->float('speed');
            $table->timestamps();

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
        Schema::dropIfExists('position');
    }
};
