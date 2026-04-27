<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('votacoes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->foreign('eleicoes_id')->references('id')->on('eleicoes');
            $table->unsignedBigInteger('eleicoes_id');
            $table->char('tipo_voto');
            $table->string('voto_candidato_id')->nullable();
            $table->foreignId('servidor_id')->constrained('servidores')->cascadeOnDelete();
            $table->string('servidor_ip_acesso');
            $table->timestamps();

            $table->unique(['eleicoes_id', 'servidor_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('votacoes');
    }
};
