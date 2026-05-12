<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            UPDATE anexos
            SET origem_id = NULL
            WHERE TRIM(CAST(origem_id AS CHAR)) = ''
        ");

        DB::statement('ALTER TABLE anexos MODIFY origem_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE anexos MODIFY origem_id VARCHAR(255) NULL');
    }
};
