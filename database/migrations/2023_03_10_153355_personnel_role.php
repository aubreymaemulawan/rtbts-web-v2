<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('personnel_role', function (Blueprint $table) {
            $table->increments('id');;
            $table->integer('personnel_id')->unsigned();
            $table->date('date_started');
            $table->date('date_ended')->nullable();
            $table->string('user_type');
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
        Schema::dropIfExists('personnel_role');
    }
};
