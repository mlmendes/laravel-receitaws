<?php

use Faker\Factory;
use Illuminate\Support\Facades\Http;
use MLMendes\LaravelReceitaWS\Facades\LaravelReceitaWS;
use MLMendes\LaravelReceitaWS\Models\Atividade;
use MLMendes\LaravelReceitaWS\Models\Empresa;
use MLMendes\LaravelReceitaWS\Models\ReceitaWSApiConfig;
use MLMendes\LaravelReceitaWS\Models\Simei;
use MLMendes\LaravelReceitaWS\Models\Simples;
use MLMendes\LaravelReceitaWS\Tests\Fixtures\ReceitaWSApiFixture;

use function Pest\Laravel\assertModelExists;
use function PHPUnit\Framework\assertNotEmpty;

test('Receita Federal method creates all empresa related models', function () {
    $faker = Factory::create(locale: 'pt_BR');
    $cnpj = $faker->cnpj();
    $data = ReceitaWSApiFixture::receitaFederalResponse($cnpj);

    $api = ReceitaWSApiConfig::factory()->create();

    Http::fake(['https://receitaws.com.br/v1/cnpj/*' => Http::response($data)]);

    LaravelReceitaWS::receitaFederal($api, $cnpj);

    Http::assertSent(function ($request) use ($api) {
        return $request->hasHeader('Authorization', 'Bearer '.$api->token);
    });

    $unformattedCnpj = preg_replace('/\D/', '', $cnpj);
    $empresa = Empresa::query()->find($unformattedCnpj);

    assertModelExists($empresa);
    assertModelExists($empresa->simples()->sole());
    assertModelExists(Simples::query()->find($unformattedCnpj)->empresa()->sole());
    assertModelExists($empresa->simei()->sole());
    assertModelExists(Simei::query()->find($unformattedCnpj)->empresa()->sole());
    assertModelExists($empresa->atividadePrincipal()->sole());
    $telefones = $empresa->telefones()->get();
    assertNotEmpty($telefones);
    foreach ($telefones as $telefone) {
        assertModelExists($telefone->empresa()->sole());
    }
    foreach ($data['atividade_principal'] as $atividade) {
        assertModelExists(Atividade::query()->where([
            'code' => $atividade['code'],
            'text' => $atividade['text'],
        ])->sole());
        assertModelExists(Atividade::query()->where('code', $atividade['code'])->sole()->principalEmpresas()->where('cnpj', $unformattedCnpj)->sole());
    }
    foreach ($data['atividades_secundarias'] as $atividade) {
        assertModelExists(Atividade::query()->where([
            'code' => $atividade['code'],
            'text' => $atividade['text'],
        ])->sole());
        assertModelExists(Atividade::query()->where('code', $atividade['code'])->sole()->secundariaEmpresas()->where('empresas.cnpj', $unformattedCnpj)->sole());
    }

    $qsa = $empresa->quadroSocietarioAdministrativo()->get();
    assertNotEmpty($qsa);

    foreach ($qsa as $socio) {
        assertModelExists($socio->empresa()->sole());
    }
});

it('throws an exception if the CNPJ is invalid', function () {
    $cnpj = '00.111.222/9999-00';

    $api = ReceitaWSApiConfig::factory()->create();

    Http::fake(['https://receitaws.com.br/v1/cnpj/*' => Http::response([
        'status' => 'ERROR',
        'message' => 'CNPJ inválido',
    ])]);

    try {
        LaravelReceitaWS::receitaFederal($api, $cnpj, days: -1);
    } catch (InvalidArgumentException $exception) {
        Http::assertNothingSent();
        throw $exception;
    }

})->throws(InvalidArgumentException::class, 'The given CNPJ is invalid.');

it('throws an exception if the days number is less than zero', function () {
    $faker = Factory::create(locale: 'pt_BR');
    $cnpj = $faker->cnpj();
    $data = ReceitaWSApiFixture::receitaFederalResponse($cnpj);

    $api = ReceitaWSApiConfig::factory()->create();

    Http::fake(['https://receitaws.com.br/v1/cnpj/*' => Http::response($data)]);

    try {
        LaravelReceitaWS::receitaFederal($api, $cnpj, days: -1);
    } catch (InvalidArgumentException $exception) {
        Http::assertNothingSent();
        throw $exception;
    }

})->throws(InvalidArgumentException::class, 'The days argument must be greater than or equal to zero.');
