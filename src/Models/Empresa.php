<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use MLMendes\LaravelReceitaWS\Database\Factories\EmpresaFactory;
use MLMendes\LaravelReceitaWS\LaravelReceitaWSRegistrar;

#[Fillable(['cnpj', 'tipo', 'porte', 'nome', 'fantasia', 'abertura', 'natureza_juridica', 'logradouro', 'numero', 'cep', 'bairro', 'municipio', 'uf', 'email', 'telefone', 'efr', 'situacao', 'data_situacao', 'motivo_situacao', 'situacao_especial', 'data_situacao_especial', 'capital_social', 'atividade_principal'])]
#[Table(key: 'cnpj', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class Empresa extends Model
{
    /** @use HasFactory<EmpresaFactory> */
    use HasFactory, SoftDeletes;

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
            'atividades_secundarias',
            'cnpj',
            'atividade_code'
        );
    }

    public function inscricoesEstaduais(): HasMany
    {
        return $this->hasMany(
            app(LaravelReceitaWSRegistrar::class)->models['inscricao_estadual'],
            'cnpj',
            'cnpj'
        );
    }

    public function quadroSocietarioAdministrativo(): HasMany
    {
        return $this->hasMany(
            app(LaravelReceitaWSRegistrar::class)->models['qsa'],
            'cnpj',
            'cnpj'
        );
    }

    public function simei(): HasOne
    {
        return $this->hasOne(
            app(LaravelReceitaWSRegistrar::class)->models['simei'],
            'cnpj',
            'cnpj'
        );
    }

    public function simeiHistorico(): HasMany
    {
        return $this->hasMany(
            app(LaravelReceitaWSRegistrar::class)->models['simei_historico'],
            'cnpj',
            'cnpj'
        );
    }

    public function simples(): HasOne
    {
        return $this->hasOne(
            app(LaravelReceitaWSRegistrar::class)->models['simples'],
            'cnpj',
            'cnpj'
        );
    }

    public function simplesHistorico(): HasMany
    {
        return $this->hasMany(
            app(LaravelReceitaWSRegistrar::class)->models['simples_historico'],
            'cnpj',
            'cnpj'
        );
    }

    public function telefones(): HasMany
    {
        return $this->hasMany(
            app(LaravelReceitaWSRegistrar::class)->models['telefone'],
            'cnpj',
            'cnpj'
        );
    }
}
