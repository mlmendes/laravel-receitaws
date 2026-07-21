<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('qsa', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('cnpj', 14);
            $table->string('nome');
            $table->string('qual');
            $table->string('pais_origem')->nullable();
            $table->string('nome_rep_legal')->nullable();
            $table->string('qual_rep_legal')->nullable();

            $table->foreign('cnpj')
                ->references('cnpj')
                ->on('empresas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unique(['cnpj', 'nome']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qsa');
    }
};