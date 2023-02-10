<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Company extends Migration
{

    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->unique();
            $table->string('address');
            $table->bigInteger('contact_no');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('description');
            $table->string('logo_name')->nullable();
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('company');
    }
};
