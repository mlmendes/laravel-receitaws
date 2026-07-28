<?php

use MLMendes\LaravelReceitaWS\Models\Atividade;
use MLMendes\LaravelReceitaWS\Models\Empresa;
use MLMendes\LaravelReceitaWS\Models\InscricaoEstadual;
use MLMendes\LaravelReceitaWS\Models\QSA;
use MLMendes\LaravelReceitaWS\Models\Simei;
use MLMendes\LaravelReceitaWS\Models\SimeiHistorico;
use MLMendes\LaravelReceitaWS\Models\Simples;
use MLMendes\LaravelReceitaWS\Models\SimplesHistorico;
use MLMendes\LaravelReceitaWS\Models\Telefone;

// config for MLMendes/LaravelReceitaWS
return [
    'models' => [
        'empresa' => Empresa::class,
        'atividade' => Atividade::class,
        'inscricao_estadual' => InscricaoEstadual::class,
        'qsa' => QSA::class,
        'simei' => Simei::class,
        'simei_historico' => SimeiHistorico::class,
        'simples' => Simples::class,
        'simples_historico' => SimplesHistorico::class,
        'telefone' => Telefone::class,
    ],
    'table_names' => [
        'atividades' => 'atividades',
        'empresas' => 'empresas',
        'telefones' => 'telefones',
        'atividades_secundarias' => 'atividades_secundarias',
        'qsa' => 'qsa',
        'simples' => 'simples',
        'simples_historico' => 'simples_historico',
        'simei' => 'simei',
        'simei_historico' => 'simei_historico',
        'inscricao_estaduals' => 'inscricoes_estaduais',
    ],
    'column_names' => [

        /**
         * Nome da coluna a ser usada como chave primária na tabela empresas
         * e chave estrangeira nas demais tabelas para referenciar o CNPJ
         */
        'cnpj' => 'cnpj',
    ],
];
