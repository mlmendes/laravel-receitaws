<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('atividades_secundarias', function (Blueprint $table) {
            $table->string('cnpj', 14);
            $table->string('atividade_code', 7);

            $table->foreign('cnpj')
                ->references('cnpj')
                ->on('empresas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreign('atividade_code')
                ->references('code')
                ->on('atividades')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unique(['cnpj', 'atividade_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atividades_secundarias');
    }
};