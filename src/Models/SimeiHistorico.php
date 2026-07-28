<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['cnpj', 'inicio', 'fim', 'detalhamento'])]
#[Table(name: 'simei_historico', key: 'uuid', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class SimeiHistorico extends Model
{
    use HasUuids;

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'cnpj', 'cnpj');
    }
}
