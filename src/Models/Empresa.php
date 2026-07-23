<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['cnpj', 'tipo', 'porte', 'nome', 'fantasia', 'abertura', 'natureza_juridica', 'logradouro', 'numero', 'cep', 'bairro', 'municipio', 'uf', 'email', 'telefone', 'efr', 'situacao', 'data_situacao', 'motivo_situacao', 'situacao_especial', 'data_situacao_especial', 'capital_social', 'atividade_principal'])]
#[Table(key: 'cnpj', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class Empresa extends Model
{
    use SoftDeletes;

    public function atividadePrincipal(): BelongsTo
    {
        return $this->belongsTo(Atividade::class, 'atividade_principal', 'code');
    }

    public function atividadesSecundarias(): BelongsToMany
    {
        return $this->belongsToMany(Atividade::class, 'atividades_secundarias', 'cnpj', 'atividade_code');
    }

    public function inscricoesEstaduais(): HasMany
    {
        return $this->hasMany(InscricaoEstadual::class, 'cnpj', 'cnpj');
    }

    public function quadroSocietarioAdministrativo(): HasMany
    {
        return $this->hasMany(QSA::class, 'cnpj', 'cnpj');
    }

    public function simei(): HasOne
    {
        return $this->hasOne(Simei::class, 'cnpj', 'cnpj');
    }

    public function simeiHistorico(): HasMany
    {
        return $this->hasMany(SimeiHistorico::class, 'cnpj', 'cnpj');
    }

    public function simples(): HasOne
    {
        return $this->hasOne(Simples::class, 'cnpj', 'cnpj');
    }

    public function simplesHistorico(): HasMany
    {
        return $this->hasMany(SimplesHistorico::class, 'cnpj', 'cnpj');
    }
}
