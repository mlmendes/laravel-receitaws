<?php

namespace MLMendes\LaravelReceitaWS\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MLMendes\LaravelReceitaWS\Models\ReceitaWSApiConfig;

class ReceitaWSApiConfigFactory extends Factory
{
    protected $model = ReceitaWSApiConfig::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'token' => Str::random(80),
            'cnpj_recurrence' => '0 0 1 * *',
            'ccc_recurrence' => '0 0 1 * *',
            'simples_recurrence' => '0 0 1 * *',
        ];
    }
}
