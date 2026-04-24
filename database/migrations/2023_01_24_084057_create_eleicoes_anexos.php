<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('anexos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('origem_id');
            $table->char('arquivo');
            $table->string('nome_original');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anexos');
    }
};