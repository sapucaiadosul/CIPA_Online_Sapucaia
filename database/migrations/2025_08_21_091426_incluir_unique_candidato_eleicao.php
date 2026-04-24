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
          Schema::table('candidatos', function (Blueprint $table) {
            $table->unique(["eleicoes_id","matricula"], 'candidato_eleicoes_unique');
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
          Schema::table('candidatos', function (Blueprint $table) {
         $table->dropUnique('candidato_eleicoes_unique');
         });
    }
};
