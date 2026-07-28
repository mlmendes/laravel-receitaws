<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['cnpj', 'numero'])]
#[Table(key: 'uuid', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
class Telefone extends Model
{
    use HasUuids;

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'cnpj', 'cnpj');
    }
}
