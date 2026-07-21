<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('atividades', function (Blueprint $table) {
            $table->string('code', 7)->primary();
            $table->string('text');
        });

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

        Schema::create('simples_historico', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('simples_id')
                ->constrained('simples', 'uuid')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->date('inicio');
            $table->date('fim')->nullable();
            $table->string('detalhamento');
        });

        Schema::create('simei', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('cnpj', 14)->unique();
            $table->boolean('optante');
            $table->date('data_opcao')->nullable();
            $table->date('data_exclusao')->nullable();
            $table->timestamp('ultima_atualizacao');

            $table->foreign('cnpj')
                ->references('cnpj')
                ->on('empresas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });

        Schema::create('simei_historico', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('simei_id')
                ->constrained('simei', 'uuid')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->date('inicio');
            $table->date('fim')->nullable();
            $table->string('detalhamento');
        });

        Schema::create('inscricoes_estaduais', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('cnpj', 14);
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

            $table->unique(['ie', 'uf']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atividades');
        Schema::dropIfExists('empresas');
        Schema::dropIfExists('atividades_secundarias');
        Schema::dropIfExists('qsa');
        Schema::dropIfExists('simples');
        Schema::dropIfExists('simples_historico');
        Schema::dropIfExists('simei');
        Schema::dropIfExists('simei_historico');
        Schema::dropIfExists('inscricoes_estaduais');
    }
};