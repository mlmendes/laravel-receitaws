<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'text'])]
#[Table(key: 'code', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class Atividade extends Model
{
    /**
     * Empresas que possuem essa atividade como principal
     *
     * @return HasMany
     */
    public function principalEmpresas(): HasMany
    {
        return $this->hasMany(Empresa::class, 'atividade_principal');
    }

    /**
     * Empresas que possuem essa atividade como secundária
     *
     * @return BelongsToMany
     */
    public function secundariaEmpresas(): BelongsToMany
    {
        return $this->belongsToMany(Empresa::class, 'atividades_secundarias', 'atividade_code', 'cnpj');
    }
}