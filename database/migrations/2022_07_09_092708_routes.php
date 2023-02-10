<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Routes extends Migration
{

    public function up()
    {
        Schema::create('route', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('from_to_location');
            $table->string('orig_address');
            $table->float('orig_latitude',10,8);
            $table->float('orig_longitude',11,8);
            $table->string('dest_address');
            $table->float('dest_latitude',10,8);
            $table->float('dest_longitude',11,8);
            $table->timestamps();

            $table->foreign('company_id')
                    ->references('id')
                    ->on('company')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('route');
    }
};
