<?php

namespace MLMendes\LaravelReceitaWS\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use MLMendes\LaravelReceitaWS\Models\Atividade;

class AtividadeFactory extends Factory
{
    protected $model = Atividade::class;

    public function definition(): array
    {
        return [
            'code' => fake()->numberBetween(1000000, 9999999),
            'text' => fake()->sentence(),
        ];
    }
}
