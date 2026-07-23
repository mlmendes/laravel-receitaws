<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['cnpj', 'optante', 'data_opcao', 'data_exclusao', 'ultima_atualizacao'])]
#[Table(name: 'simei', key: 'cnpj', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class Simei extends Model
{
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'cnpj', 'cnpj');
    }
}
