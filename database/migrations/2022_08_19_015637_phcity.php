<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PHCity extends Migration
{

    public function up()
    {
        \DB::unprepared( file_get_contents( "public/db/ph_city.sql" ) );
    }

    public function down()
    {
        Schema::dropIfExists('ph_city');
    }
};
