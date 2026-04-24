<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('eleicoes_id');
            $table->foreign('eleicoes_id')->references('id')->on('eleicoes');
            $table->string('matricula');
            $table->string('nome')->nullable();
            $table->string('apelido')->nullable();
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->date('dt_nascimento')->nullable();
            $table->string('cpf')->nullable();
            $table->string('lotacao')->nullable();
            $table->string('cargo_funcao')->nullable();
            $table->boolean('indicado')->nullable();
            $table->boolean('vinculo')->nullable();
            $table->boolean('estabilidade')->nullable();
            $table->string('foto')->nullable()->default(NULL);
            $table->string('historico')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidatos');
    }
};
