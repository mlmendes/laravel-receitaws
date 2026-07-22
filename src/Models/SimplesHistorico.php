<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['simples_id', 'inicio', 'fim', 'detalhamento'])]
#[Table(name: 'simples_historico', key: 'uuid', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class SimplesHistorico extends Model
{
    use HasUuids;

    public function simples(): BelongsTo
    {
        return $this->belongsTo(Simples::class);
    }
}