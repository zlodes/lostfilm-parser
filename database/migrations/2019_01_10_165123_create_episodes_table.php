<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('season_id');

            $table->string('name');
            $table->string('original_name')->nullable(); // For non-russians episode titles

            $table->string('slug'); // Part of lostfilm.tv url
            $table->string('lostfilm_url', 1000);

            $table->date('release_date');

            $table->timestamps();

            $table->index('slug');

            $table->foreign('season_id')->references('id')->on('seasons')
                ->onDelete('restrict')->onUpdate('restrict');
        });
    }

    public function down()
    {
        Schema::drop('episodes');
    }
}
