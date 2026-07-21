<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['cnpj', 'optante', 'data_opcao', 'data_exclusao', 'ultima_atualizacao'])]
#[Table(name: 'simei', key: 'uuid', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class Simei extends Model
{
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function historicos(): HasMany
    {
        return $this->hasMany(SimeiHistorico::class);
    }
}