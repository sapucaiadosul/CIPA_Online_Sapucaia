<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            UPDATE votacoes
            SET voto_candidato_id = NULL
            WHERE TRIM(CAST(voto_candidato_id AS CHAR)) = ''
        ");

        DB::statement('ALTER TABLE votacoes MODIFY voto_candidato_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE votacoes MODIFY voto_candidato_id VARCHAR(255) NULL');
    }
};
