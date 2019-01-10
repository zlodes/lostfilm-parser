<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonTable extends Migration
{
    public function up()
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('series_id');

            $table->string('name');
            $table->string('original_name')->nullable(); // For non-russian season names

            $table->string('slug'); // Part of lostfilm.tv url

            $table->timestamps();

            $table->index('slug');

            $table->foreign('series_id')->references('id')->on('series')
                ->onDelete('restrict')->onUpdate('restrict');
        });
    }

    public function down()
    {
        Schema::drop('seasons');
    }
}
