<?php

namespace MLMendes\LaravelReceitaWS\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MLMendes\LaravelReceitaWS\LaravelReceitaWS
 */
class LaravelReceitaWS extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MLMendes\LaravelReceitaWS\LaravelReceitaWS::class;
    }
}
