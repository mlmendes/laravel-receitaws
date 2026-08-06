<?php

namespace MLMendes\LaravelReceitaWS;

class ReceitaWSRegistrar
{
    public array $models;

    public function __construct()
    {
        $this->models = config('receitaws.models');
    }
}
