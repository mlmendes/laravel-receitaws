<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('simples', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('cnpj', 14)->unique();
            $table->boolean('optante');
            $table->date('data_opcao');
            $table->date('data_exclusao');
            $table->timestamp('ultima_atualizacao');

            $table->foreign('cnpj')
                ->references('cnpj')
                ->on('empresas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simples');
    }
};