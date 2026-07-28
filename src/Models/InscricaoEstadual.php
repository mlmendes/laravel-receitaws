<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['cnpj', 'uf', 'ie', 'tipo_ie', 'situacao_ie', 'data_situacao', 'regime_icms', 'situacao_cnpj', 'data_atualizacao'])]
#[Table(name: 'inscricoes_estaduais', key: 'uuid', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class InscricaoEstadual extends Model
{
    use HasUuids;

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }
}
