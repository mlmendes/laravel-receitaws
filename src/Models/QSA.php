<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MLMendes\LaravelReceitaWS\LaravelReceitaWSRegistrar;

/**
 * @property string $uuid
 * @property string $cnpj
 * @property string $nome
 * @property string $qual
 * @property string|null $pais_origem
 * @property string|null $nome_rep_legal
 * @property string|null $qual_rep_legal
 */
#[Fillable(['cnpj', 'nome', 'qual', 'pais_origem', 'nome_rep_legal', 'qual_rep_legal'])]
#[Table(name: 'qsa', key: 'uuid', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class QSA extends Model
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
