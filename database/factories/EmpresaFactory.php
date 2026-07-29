<?php

namespace MLMendes\LaravelReceitaWS\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use MLMendes\LaravelReceitaWS\Models\Atividade;
use MLMendes\LaravelReceitaWS\Models\Empresa;

class EmpresaFactory extends Factory
{
    protected $model = Empresa::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create(locale: 'pt_BR');

        return [
            'cnpj' => $faker->cnpj(false),
            'tipo' => 'MATRIZ',
            'porte' => 'MICRO EMPRESA',
            'nome' => $faker->company(),
            'fantasia' => $faker->company(),
            'abertura' => $faker->date(),
            'natureza_juridica' => $faker->sentence(),
            'logradouro' => $faker->streetName(),
            'numero' => $faker->buildingNumber(),
            'complemento' => $faker->secondaryAddress(),
            'cep' => $faker->postcode(),
            'bairro' => $faker->streetSuffix(),
            'municipio' => $faker->city(),
            'uf' => $faker->stateAbbr(),
            'email' => $faker->email(),
            'efr' => '',
            'situacao' => 'ATIVA',
            'data_situacao' => $faker->date(),
            'motivo_situacao' => $faker->sentence(),
            'situacao_especial' => '',
            'data_situacao_especial' => null,
            'capital_social' => (string)$faker->numberBetween(1, 99999999),
            'atividade_principal' => Atividade::factory(),
        ];
    }
}
