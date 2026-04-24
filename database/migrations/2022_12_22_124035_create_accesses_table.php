<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessesTable extends Migration
{
    public function up()
    {
        Schema::create('accesses', function (Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->bigIncrements('id');
        $table->unsignedBigInteger('user_id')->unsigned();
        $table->string('type');
        $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accesses');
    }
}