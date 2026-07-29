<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MLMendes\LaravelReceitaWS\Database\Factories\AtividadeFactory;
use MLMendes\LaravelReceitaWS\LaravelReceitaWSRegistrar;

#[Fillable(['code', 'text'])]
#[Table(key: 'code', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class Atividade extends Model
{
    /** @use HasFactory<AtividadeFactory> */
    use HasFactory;

    /**
     * Empresas que possuem essa atividade como principal
     */
    public function principalEmpresas(): HasMany
    {
        return $this->hasMany(app(LaravelReceitaWSRegistrar::class)->models['empresa'], 'atividade_principal');
    }

    /**
     * Empresas que possuem essa atividade como secundária
     */
    public function secundariaEmpresas(): BelongsToMany
    {
        return $this->belongsToMany(app(LaravelReceitaWSRegistrar::class)->models['empresa'], 'atividades_secundarias', 'atividade_code', 'cnpj');
    }
}
