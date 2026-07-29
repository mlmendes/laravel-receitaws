<?php

namespace MLMendes\LaravelReceitaWS;

class LaravelReceitaWSRegistrar
{
    public array $models;

    public function __construct()
    {
        $this->models = config('receitaws.models');
    }
}
