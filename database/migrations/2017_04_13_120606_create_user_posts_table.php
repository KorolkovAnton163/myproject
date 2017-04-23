<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPostsTable extends Migration
{
    public function up()
    {
        Schema::create('entry_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('entry_id')->unsigned();
        });

        Schema::table('entry_user', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('entry_id')->references('id')->on('entries');
        });
    }

    public function down()
    {
        Schema::drop('entry_user');
    }
}
