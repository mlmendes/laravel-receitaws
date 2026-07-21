<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inscricoes_estaduais', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('cnpj', 14)->unique();
            $table->string('uf', 2);
            $table->string('ie');
            $table->string('tipo_ie');
            $table->string('situacao_ie');
            $table->date('data_situacao')->nullable();
            $table->string('regime_icms');
            $table->string('situacao_cnpj');
            $table->date('data_atualizacao');

            $table->foreign('cnpj')
                ->references('cnpj')
                ->on('empresas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unique(['cnpj', 'uf']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscricoes_estaduais');
    }
};