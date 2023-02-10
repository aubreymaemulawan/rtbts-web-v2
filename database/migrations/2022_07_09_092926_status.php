<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Status extends Migration
{

    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trip_id')->unsigned();
            $table->integer('bus_status'); // 1 = LoadingPassenger, 2 = Break, 3 = Departed, 4 = Cancelled, 5 = Arrived
            $table->decimal('latitude', 10,8);
            $table->decimal('longitude', 11,8);
            $table->timestamps();

            $table->foreign('trip_id')
                    ->references('id')
                    ->on('trip')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('status');
    }
};
