<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use MLMendes\LaravelReceitaWS\Database\Factories\ReceitaWSApiConfigFactory;

/**
 * @property string $uuid
 * @property string $name
 * @property string $token
 * @property string $cnpj_recurrence
 * @property string $ccc_recurrence
 * @property string $simples_recurrence
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'token', 'cnpj_recurrence', 'ccc_recurrence', 'simples_recurrence'])]
#[Hidden('token')]
#[Table(name: 'receitaws_api_config', key: 'uuid', keyType: 'string', incrementing: false)]
class ReceitaWSApiConfig extends Model
{
    /** @use HasFactory<ReceitaWSApiConfigFactory> */
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'token' => 'encrypted',
        ];
    }
}
