<?php

namespace MLMendes\LaravelReceitaWS\Models;


use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['cnpj', 'nome', 'qual', 'pais_origem', 'nome_rep_legal', 'qual_rep_legal'])]
#[Table(name: 'qsa', key: 'uuid', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class QSA extends Model
{
    use HasUuids;

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }
}