<?php

use Faker\Factory;
use MLMendes\LaravelReceitaWS\Facades\ReceitaWS;
use MLMendes\LaravelReceitaWS\Models\ReceitaWSApiConfig;

use function PHPUnit\Framework\assertCount;

it('throws an exception if the days number is less than zero', function () {
    $faker = Factory::create(locale: 'pt_BR');
    // @phpstan-ignore method.notFound
    $cnpj = $faker->cnpj();

    $api = ReceitaWSApiConfig::factory()->create();

    Http::fake(['https://receitaws.com.br/v1/*' => Http::response([
        'status' => 'ERROR',
        'message' => 'invalid days parameter',
    ])]);

    $exceptions = [];

    try {
        ReceitaWS::receitaFederal($api, $cnpj, days: -1);
    } catch (InvalidArgumentException $exception) {
        Http::assertNothingSent();
        $exceptions[] = $exception;
    }

    try {
        ReceitaWS::cadastroDeContribuinte($api, $cnpj, days: -1);
    } catch (InvalidArgumentException $exception) {
        Http::assertNothingSent();
        $exceptions[] = $exception;
    }

    try {
        ReceitaWS::simplesNacional($api, $cnpj, days: -1);
    } catch (InvalidArgumentException $exception) {
        Http::assertNothingSent();
        $exceptions[] = $exception;
    }

    assertCount(3, $exceptions);
});

it('throws an exception if the CNPJ is invalid', function () {
    $cnpj = '00.111.222/9999-00';

    $api = ReceitaWSApiConfig::factory()->create();

    Http::fake(['https://receitaws.com.br/v1/cnpj/*' => Http::response([
        'status' => 'ERROR',
        'message' => 'CNPJ inválido',
    ])]);

    $exceptions = [];

    try {
        ReceitaWS::receitaFederal($api, $cnpj, days: -1);
    } catch (InvalidArgumentException $exception) {
        Http::assertNothingSent();
        $exceptions[] = $exception;
    }

    try {
        ReceitaWS::cadastroDeContribuinte($api, $cnpj, days: -1);
    } catch (InvalidArgumentException $exception) {
        Http::assertNothingSent();
        $exceptions[] = $exception;
    }

    try {
        ReceitaWS::simplesNacional($api, $cnpj, days: -1);
    } catch (InvalidArgumentException $exception) {
        Http::assertNothingSent();
        $exceptions[] = $exception;
    }

    assertCount(3, $exceptions);
});
