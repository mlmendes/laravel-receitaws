<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use MLMendes\LaravelReceitaWS\LaravelReceitaWSRegistrar;

#[WithoutTimestamps]
class Empresa extends Model
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->fillable([
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            'tipo',
            'porte',
            'nome',
            'fantasia',
            'abertura',
            'natureza_juridica',
            'logradouro',
            'numero',
            'cep',
            'bairro',
            'municipio',
            'uf',
            'email',
            'telefone',
            'efr',
            'situacao',
            'data_situacao',
            'motivo_situacao',
            'situacao_especial',
            'data_situacao_especial',
            'capital_social',
            'atividade_principal',
        ]);
        $this->setTable(app(LaravelReceitaWSRegistrar::class)->tableNames['empresas']);
        $this->setKeyName(app(LaravelReceitaWSRegistrar::class)->cnpjColumn);
        $this->setKeyType('string');
        $this->setIncrementing(false);
    }

    public function atividadePrincipal(): BelongsTo
    {
        return $this->belongsTo(
            app(LaravelReceitaWSRegistrar::class)->models['atividade'],
            'atividade_principal',
            'code'
        );
    }

    public function atividadesSecundarias(): BelongsToMany
    {
        return $this->belongsToMany(
            app(LaravelReceitaWSRegistrar::class)->models['atividade'],
            app(LaravelReceitaWSRegistrar::class)->tableNames['atividades_secundarias'],
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            'atividade_code'
        );
    }

    public function inscricoesEstaduais(): HasMany
    {
        return $this->hasMany(
            app(LaravelReceitaWSRegistrar::class)->models['inscricao_estadual'],
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }

    public function quadroSocietarioAdministrativo(): HasMany
    {
        return $this->hasMany(
            app(LaravelReceitaWSRegistrar::class)->models['qsa'],
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }

    public function simei(): HasOne
    {
        return $this->hasOne(
            app(LaravelReceitaWSRegistrar::class)->models['simei'],
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }

    public function simeiHistorico(): HasMany
    {
        return $this->hasMany(
            app(LaravelReceitaWSRegistrar::class)->models['simei_historico'],
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }

    public function simples(): HasOne
    {
        return $this->hasOne(
            app(LaravelReceitaWSRegistrar::class)->models['simples'],
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }

    public function simplesHistorico(): HasMany
    {
        return $this->hasMany(
            app(LaravelReceitaWSRegistrar::class)->models['simples_historico'],
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }

    public function telefones(): HasMany
    {
        return $this->hasMany(
            app(LaravelReceitaWSRegistrar::class)->models['telefone'],
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }
}
