<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Account extends Migration
{

    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('personnel_id')->unsigned()->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();

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
        Schema::dropIfExists('account');
    }
};
