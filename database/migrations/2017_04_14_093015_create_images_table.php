<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('path');
            $table->string('extension');
            $table->timestamps();
        });

        Schema::create('entry_image', function (Blueprint $table) {
            $table->integer('entry_id')->unsigned();
            $table->integer('image_id')->unsigned();
        });
    }

    public function down()
    {
        Schema::drop('images');
        Schema::drop('entry_image');
    }
}
