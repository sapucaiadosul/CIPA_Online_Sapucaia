<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servidores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('matricula')->unique();
            $table->string('cpf')->unique();
            $table->date('dt_nascimento');
            $table->string('vinculo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servidores');
    }
};
