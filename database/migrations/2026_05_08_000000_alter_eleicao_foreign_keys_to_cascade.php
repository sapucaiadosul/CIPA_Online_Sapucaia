<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('candidatos', function (Blueprint $table) {
            $table->dropForeign(['eleicoes_id']);
            $table->foreign('eleicoes_id')
                ->references('id')
                ->on('eleicoes')
                ->cascadeOnDelete();
        });

        Schema::table('votacoes', function (Blueprint $table) {
            $table->dropForeign(['eleicoes_id']);
            $table->foreign('eleicoes_id')
                ->references('id')
                ->on('eleicoes')
                ->cascadeOnDelete();
        });

        Schema::table('anexos', function (Blueprint $table) {
            $table->foreign('origem_id')
                ->references('id')
                ->on('eleicoes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('anexos', function (Blueprint $table) {
            $table->dropForeign(['origem_id']);
        });

        Schema::table('votacoes', function (Blueprint $table) {
            $table->dropForeign(['eleicoes_id']);
            $table->foreign('eleicoes_id')
                ->references('id')
                ->on('eleicoes');
        });

        Schema::table('candidatos', function (Blueprint $table) {
            $table->dropForeign(['eleicoes_id']);
            $table->foreign('eleicoes_id')
                ->references('id')
                ->on('eleicoes');
        });
    }
};
