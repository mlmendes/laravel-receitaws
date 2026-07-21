<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->string('cnpj', 14)->primary();
            $table->enum('tipo', ['MATRIZ', 'FILIAL']);
            $table->string('porte');
            $table->string('nome');
            $table->string('fantasia');
            $table->date('abertura');
            $table->string('natureza_juridica');
            $table->string('logradouro');
            $table->string('numero');
            $table->string('cep');
            $table->string('bairro');
            $table->string('municipio');
            $table->string('uf');
            $table->string('email');
            $table->string('telefone');
            $table->string('efr');
            $table->string('situacao');
            $table->date('data_situacao');
            $table->string('motivo_situacao');
            $table->string('situacao_especial');
            $table->date('data_situacao_especial');
            $table->decimal('capital_social');
            $table->string('atividade_principal', 7);

            $table->foreign('atividade_principal')
                ->references('code')
                ->on('atividades')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};