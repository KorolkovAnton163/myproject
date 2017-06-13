<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEntryStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('user_entry_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('entry_id');
            $table->integer('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('user_entry_statuses');
    }
}
