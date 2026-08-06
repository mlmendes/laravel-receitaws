<?php

namespace MLMendes\LaravelReceitaWS\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MLMendes\LaravelReceitaWS\ReceitaWS
 */
class ReceitaWS extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MLMendes\LaravelReceitaWS\ReceitaWS::class;
    }
}
