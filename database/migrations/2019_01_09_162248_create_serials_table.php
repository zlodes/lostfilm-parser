<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerialsTable extends Migration
{
    public function up()
    {
        Schema::create('serials', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();
            $table->string('original_name')->nullable(); // For serials with non-russian titles

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('serials');
    }
}
