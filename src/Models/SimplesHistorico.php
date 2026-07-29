<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use MLMendes\LaravelReceitaWS\LaravelReceitaWSRegistrar;

/**
 * @property string $uuid
 * @property string $cnpj
 * @property Carbon $inicio
 * @property Carbon|null $fim
 * @property string $detalhamento
 */
#[Fillable(['cnpj', 'inicio', 'fim', 'detalhamento'])]
#[Table(name: 'simples_historico', key: 'uuid', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class SimplesHistorico extends Model
{
    use HasUuids;

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(
            app(LaravelReceitaWSRegistrar::class)->models['empresa'],
            'cnpj',
            'cnpj'
        );
    }
}
