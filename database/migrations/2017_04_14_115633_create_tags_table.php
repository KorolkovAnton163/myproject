<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('entry_tag', function (Blueprint $table) {
            $table->integer('entry_id')->unsigned();
            $table->integer('tag_id')->unsigned();
        });
    }

    public function down()
    {
        Schema::drop('tags');
        Schema::drop('entry_tag');
    }
}
