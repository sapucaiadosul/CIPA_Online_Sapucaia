<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!in_array(Schema::getConnection()->getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        DB::statement("
            UPDATE votacoes
            SET voto_candidato_id = NULL
            WHERE TRIM(CAST(voto_candidato_id AS CHAR)) = ''
        ");

        DB::statement("
            UPDATE anexos
            SET origem_id = NULL
            WHERE TRIM(CAST(origem_id AS CHAR)) = ''
        ");

        DB::statement('
            UPDATE anexos a
            LEFT JOIN eleicoes e ON e.id = a.origem_id
            SET a.origem_id = NULL
            WHERE a.origem_id IS NOT NULL AND e.id IS NULL
        ');

        $candidatosOrfaos = DB::table('candidatos')
            ->leftJoin('eleicoes', 'eleicoes.id', '=', 'candidatos.eleicoes_id')
            ->whereNull('eleicoes.id')
            ->count();

        $votacoesOrfaas = DB::table('votacoes')
            ->leftJoin('eleicoes', 'eleicoes.id', '=', 'votacoes.eleicoes_id')
            ->whereNull('eleicoes.id')
            ->count();

        if ($candidatosOrfaos > 0 || $votacoesOrfaas > 0) {
            throw new RuntimeException(
                'Existem registros órfãos em candidatos ou votacoes. Corrija os dados antes de rodar esta migration no MySQL.'
            );
        }

        DB::statement('ALTER TABLE votacoes MODIFY eleicoes_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE votacoes MODIFY voto_candidato_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE anexos MODIFY origem_id BIGINT UNSIGNED NULL');

        $this->dropForeignIfExists('candidatos', 'candidatos_eleicoes_id_foreign');
        $this->dropForeignIfExists('votacoes', 'votacoes_eleicoes_id_foreign');
        $this->dropForeignIfExists('anexos', 'anexos_origem_id_foreign');

        DB::statement('ALTER TABLE candidatos ADD CONSTRAINT candidatos_eleicoes_id_foreign FOREIGN KEY (eleicoes_id) REFERENCES eleicoes(id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE votacoes ADD CONSTRAINT votacoes_eleicoes_id_foreign FOREIGN KEY (eleicoes_id) REFERENCES eleicoes(id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE anexos ADD CONSTRAINT anexos_origem_id_foreign FOREIGN KEY (origem_id) REFERENCES eleicoes(id) ON DELETE SET NULL');
    }

    public function down(): void
    {
        if (!in_array(Schema::getConnection()->getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        $this->dropForeignIfExists('anexos', 'anexos_origem_id_foreign');
        $this->dropForeignIfExists('votacoes', 'votacoes_eleicoes_id_foreign');
        $this->dropForeignIfExists('candidatos', 'candidatos_eleicoes_id_foreign');

        DB::statement('ALTER TABLE anexos MODIFY origem_id VARCHAR(255) NULL');
        DB::statement('ALTER TABLE votacoes MODIFY voto_candidato_id VARCHAR(255) NULL');

        DB::statement('ALTER TABLE candidatos ADD CONSTRAINT candidatos_eleicoes_id_foreign FOREIGN KEY (eleicoes_id) REFERENCES eleicoes(id)');
        DB::statement('ALTER TABLE votacoes ADD CONSTRAINT votacoes_eleicoes_id_foreign FOREIGN KEY (eleicoes_id) REFERENCES eleicoes(id)');
    }

    private function dropForeignIfExists(string $tableName, string $constraintName): void
    {
        $databaseName = DB::getDatabaseName();

        $constraint = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', $databaseName)
            ->where('TABLE_NAME', $tableName)
            ->where('CONSTRAINT_NAME', $constraintName)
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->exists();

        if ($constraint) {
            DB::statement("ALTER TABLE {$tableName} DROP FOREIGN KEY {$constraintName}");
        }
    }
};
