<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesTable extends Migration
{
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();
            $table->string('original_name')->nullable(); // For serials with non-russian titles

            $table->string('slug')->unique(); // Part of lostfilm.tv url

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('series');
    }
}
