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
        //
        Schema::table('votacoes', function (Blueprint $table) {
            $table->dropUnique('votacoes_eleitor_matricula_unique');
            $table->unique(["eleitor_matricula", "eleicoes_id"], 'eleitor_eleicoes_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('votacoes', function (Blueprint $table) {
         $table->dropUnique('eleitor_eleicoes_unique');
         });
    }
};
