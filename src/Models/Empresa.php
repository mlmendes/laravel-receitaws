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
        parent::__construct();
    }

    public function atividadePrincipal(): BelongsTo
    {
        return $this->belongsTo(
            Atividade::class,
            app(LaravelReceitaWSRegistrar::class)->tableNames['atividade_principal'],
            'code'
        );
    }

    public function atividadesSecundarias(): BelongsToMany
    {
        return $this->belongsToMany(
            Atividade::class,
            app(LaravelReceitaWSRegistrar::class)->tableNames['atividades_secundarias'],
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            'atividade_code'
        );
    }

    public function inscricoesEstaduais(): HasMany
    {
        return $this->hasMany(
            InscricaoEstadual::class,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }

    public function quadroSocietarioAdministrativo(): HasMany
    {
        return $this->hasMany(
            QSA::class,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }

    public function simei(): HasOne
    {
        return $this->hasOne(
            Simei::class,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }

    public function simeiHistorico(): HasMany
    {
        return $this->hasMany(SimeiHistorico::class,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }

    public function simples(): HasOne
    {
        return $this->hasOne(
            Simples::class,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }

    public function simplesHistorico(): HasMany
    {
        return $this->hasMany(
            SimplesHistorico::class,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }

    public function telefones(): HasMany
    {
        return $this->hasMany(
            Telefone::class,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn,
            app(LaravelReceitaWSRegistrar::class)->cnpjColumn
        );
    }
}
