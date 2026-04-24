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
        Schema::create('eleicoes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('descricao_eleicao');
            $table->datetime('dt_vigencia_de')->nullable();
            $table->datetime('dt_vigencia_ate')->nullable();
            $table->string('numero_indicados')->nullable();
            $table->string('numero_nao_indicados')->nullable();
            $table->string('numero_eleitos')->nullable();
            $table->datetime('dt_inscricao_de')->nullable();
            $table->datetime('dt_inscricao_ate')->nullable();
            $table->datetime('dt_votacao_de')->nullable();
            $table->datetime('dt_votacao_ate')->nullable();
            $table->datetime('dt_resultados')->nullable();
            $table->datetime('dt_edital_nominal')->nullable();
            $table->string('obs_anexos')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('eleicoes');
    }
};
