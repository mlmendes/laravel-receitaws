<?php

namespace MLMendes\LaravelReceitaWS\Tests\Fixtures;

use Faker\Factory;

class ReceitaWSApiFixture
{
    public static function receitaFederalResponse(?string $cnpj): array
    {
        $faker = Factory::create(locale: 'pt_BR');

        return [
            // @phpstan-ignore method.notFound
            'cnpj' => $cnpj ?? $faker->cnpj(false),
            'abertura' => $faker->date('d/m/Y'),
            'situacao' => 'ATIVA',
            'tipo' => 'MATRIZ',
            'nome' => $faker->company(),
            'fantasia' => $faker->company(),
            'porte' => 'MICRO EMPRESA',
            'natureza_juridica' => $faker->sentence(),
            'qsa' => [[
                'nome' => $faker->firstName().' '.$faker->lastName(),
                'qual' => '49-Sócio-Administrador',
            ]],
            'logradouro' => $faker->streetName(),
            'numero' => $faker->buildingNumber(),
            // @phpstan-ignore method.notFound
            'complemento' => $faker->secondaryAddress(),
            'municipio' => $faker->city(),
            'bairro' => $faker->streetSuffix(),
            // @phpstan-ignore method.notFound
            'uf' => $faker->stateAbbr(),
            'cep' => $faker->postcode(),
            'email' => $faker->email(),
            'telefone' => "{$faker->landlineNumber()} / {$faker->cellphoneNumber()}",
            'data_situacao' => $faker->date('d/m/Y'),
            'atividade_principal' => [[
                'code' => (string) $faker->numberBetween(1000000, 9999999),
                'text' => $faker->sentence(),
            ]],
            'atividades_secundarias' => [[
                'code' => (string) $faker->numberBetween(1000000, 9999999),
                'text' => $faker->sentence(),
            ]],
            'ultima_atualizacao' => $faker->date('c'),
            'status' => 'OK',
            'efr' => '',
            'situacao_especial' => '',
            'motivo_situacao' => $faker->sentence(),
            'data_situacao_especial' => '',
            'capital_social' => (string) $faker->numberBetween(1, 99999999),
            'simples' => [
                'optante' => $faker->boolean(),
                'data_opcao' => $faker->date('d/m/Y'),
                'data_exclusao' => $faker->date('d/m/Y'),
                'ultima_atualizacao' => $faker->date('c'),
            ],
            'simei' => [
                'optante' => $faker->boolean(),
                'data_opcao' => $faker->date('d/m/Y'),
                'data_exclusao' => $faker->date('d/m/Y'),
                'ultima_atualizacao' => $faker->date('c'),
            ],
        ];
    }

    public static function cadastroDeContribuinteResponse(?string $cnpj): array
    {
        $faker = Factory::create(locale: 'pt_BR');

        return [
            // @phpstan-ignore method.notFound
            'cnpj' => $cnpj ?? $faker->cnpj(false),
            'ultima_atualizacao' => $faker->date('c'),
            'status' => 'OK',
            'registros' => [[
                // @phpstan-ignore method.notFound
                'uf' => $faker->stateAbbr(),
                'ie' => (string) $faker->numberBetween(1000000000, 99999999999),
                'tipo_ie' => 'IE Normal',
                'situacao_ie' => 'Habilitado',
                'data_situacao' => $faker->date('d/m/Y'),
                'regime_icms' => 'Simples Nacional',
                'situacao_cnpj' => 'Sem restrição',
                'data_atualizacao' => $faker->date('d/m/Y'),
            ]],
            'billing' => [
                'free' => $faker->boolean(),
                'database' => $faker->boolean(),
            ],
        ];
    }

    public static function simplesNacionalResponse(?string $cnpj): array
    {
        $faker = Factory::create(locale: 'pt_BR');

        return [
            // @phpstan-ignore method.notFound
            'cnpj' => $cnpj ?? $faker->cnpj(false),
            'simples' => [
                'optante' => $faker->boolean(),
                'data_opcao' => $faker->date(),
                'historico' => [
                    'periodos_anteriores' => [[
                        'inicio' => $faker->date(),
                        'fim' => $faker->date(),
                        'detalhamento' => $faker->sentence(),
                    ]],
                ],
            ],
            'simei' => [
                'optante' => $faker->boolean(),
                'data_opcao' => $faker->date(),
                'historico' => [
                    'periodos_anteriores' => [[
                        'inicio' => $faker->date(),
                        'fim' => $faker->date(),
                        'detalhamento' => $faker->sentence(),
                    ]],
                ],
            ],
            'billing' => [
                'free' => $faker->boolean(),
                'database' => $faker->boolean(),
            ],
        ];
    }
}
