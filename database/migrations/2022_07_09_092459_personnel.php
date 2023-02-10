<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Personnel extends Migration
{

    public function up()
    {
        Schema::create('personnel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('personnel_no')->unique();
            $table->integer('company_id')->unsigned();
            $table->string('name')->unique();
            $table->bigInteger('contact_no');
            $table->integer('age');
            $table->string('address');
            $table->string('profile_name')->nullable();
            $table->string('profile_path')->nullable();
            $table->integer('user_type'); // 2 = Conductor, 3 = Dispatcher, 4 = Operator
            $table->integer('status'); // 1 = Active, 2 = Inactive
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
        Schema::dropIfExists('personnel');
    }
};
