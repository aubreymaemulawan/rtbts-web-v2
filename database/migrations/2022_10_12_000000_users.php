<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->unique()->nullable();
            $table->integer('personnel_id')->unsigned()->unique()->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('user_type'); // 1 = Admin, 2 = Conductor, 3 = Dispatcher, 4 = Operator
            $table->rememberToken();
            $table->timestamps(); 

            $table->foreign('company_id')
                    ->references('id')
                    ->on('company')
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
        Schema::dropIfExists('users');
    }
};
