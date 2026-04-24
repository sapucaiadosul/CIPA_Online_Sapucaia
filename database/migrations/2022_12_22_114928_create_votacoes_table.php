<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votacoes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
      //    $table->unsignedBigInteger('votacao_realizada');
            $table->foreign('eleicoes_id')->references('id')->on('eleicoes');
            $table->string('eleitor_matricula')->unique();
            $table->unsignedBigInteger('eleicoes_id');
            $table->char('tipo_voto');
            $table->string('voto_candidato_id')->nullable();
            $table->string('eleitor_nome');
            $table->string('eleitor_cpf');
            $table->string('eleitor_lotacao')->nullable();
            $table->string('eleitor_cargo_funcao')->nullable();
            $table->string('eleitor_IP_acesso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votacoes');
    }
};
