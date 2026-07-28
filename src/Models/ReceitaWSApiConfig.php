<?php

namespace MLMendes\LaravelReceitaWS\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string $uuid
 * @property string $name
 * @property string $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'token'])]
#[Hidden('token')]
#[Table(name: 'receitaws_api_config', key: 'uuid', keyType: 'string', incrementing: false)]
class ReceitaWSApiConfig extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'token' => 'encrypted',
        ];
    }
}
