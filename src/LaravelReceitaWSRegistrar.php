<?php

namespace MLMendes\LaravelReceitaWS;

class LaravelReceitaWSRegistrar
{
    public array $tableNames;

    public array $models;

    public string $cnpjColumn;

    public function __construct()
    {
        $this->tableNames = config('receitaws.table_names');
        $this->cnpjColumn = config('receitaws.column_names.cnpj');
        $this->models = config('receitaws.models');
    }
}
