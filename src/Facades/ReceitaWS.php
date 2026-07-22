<?php

namespace MLMendes\LaravelReceitaWS\Facades;

use Illuminate\Support\Facades\Facade;
use MLMendes\LaravelReceitaWS\Enum\Fallback;
use MLMendes\LaravelReceitaWS\Models\ReceitaWS as ReceitaWSModel;

/**
 * @method \MLMendes\LaravelReceitaWS\ReceitaWS receitaFederal(ReceitaWSModel $receitaWS, string $cnpj, int $days = 0, Fallback $fallback = Fallback::CACHE_ON_ERROR)
 *
 * @see \MLMendes\LaravelReceitaWS\ReceitaWS
 */
class ReceitaWS extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MLMendes\LaravelReceitaWS\ReceitaWS::class;
    }
}
