<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use MLMendes\LaravelReceitaWS\ReceitaWSRegistrar;

/**
 * @property string $cnpj
 * @property bool|null $optante
 * @property Carbon|null $data_opcao
 * @property Carbon|null $data_exclusao
 * @property Carbon|null $ultima_atualizacao
 */
#[Fillable(['cnpj', 'optante', 'data_opcao', 'data_exclusao', 'ultima_atualizacao'])]
#[Table(name: 'simei', key: 'cnpj', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class Simei extends Model
{
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(
            app(ReceitaWSRegistrar::class)->models['empresa'],
            'cnpj',
            'cnpj'
        );
    }
}
