<?php

use MLMendes\LaravelReceitaWS\Facades\LaravelReceitaWS;
use MLMendes\LaravelReceitaWS\Models\Empresa;
use MLMendes\LaravelReceitaWS\Models\ReceitaWSApiConfig;
use MLMendes\LaravelReceitaWS\Models\Simei;
use MLMendes\LaravelReceitaWS\Models\SimeiHistorico;
use MLMendes\LaravelReceitaWS\Models\Simples;
use MLMendes\LaravelReceitaWS\Models\SimplesHistorico;
use MLMendes\LaravelReceitaWS\Tests\Fixtures\ReceitaWSApiFixture;
use function Pest\Laravel\assertModelExists;

it('creates related models', function () {
    $empresa = Empresa::factory()->create();

    $data = ReceitaWSApiFixture::simplesNacionalResponse($empresa->cnpj);

    $api = ReceitaWSApiConfig::factory()->create();
    Http::fake(['https://receitaws.com.br/v1/simples/*' => Http::response($data)]);

    LaravelReceitaWS::simplesNacional($api, $empresa->cnpj);

    Http::assertSent(function ($request) use ($api) {
        return $request->hasHeader('Authorization', 'Bearer ' . $api->token);
    });

    assertModelExists($empresa->simples()->sole());
    assertModelExists(Simples::query()->where(['cnpj' => $empresa->cnpj])->sole()->empresa()->sole());

    foreach ($data['simples']['historico']['periodos_anteriores'] as $periodo) {
        assertModelExists($empresa->simplesHistorico()->where([
            'inicio' => $periodo['inicio'],
            'fim' => $periodo['fim'],
        ])->sole());
        assertModelExists(SimplesHistorico::query()->where([
            'inicio' => $periodo['inicio'],
            'fim' => $periodo['fim'],
            'cnpj' => $empresa->cnpj,
        ])->sole()->empresa()->sole());
    }

    assertModelExists($empresa->simei()->sole());
    assertModelExists(Simei::query()->where(['cnpj' => $empresa->cnpj])->sole()->empresa()->sole());

    foreach ($data['simei']['historico']['periodos_anteriores'] as $periodo) {
        assertModelExists($empresa->simeiHistorico()->where([
            'inicio' => $periodo['inicio'],
            'fim' => $periodo['fim'],
        ])->sole());
        assertModelExists(SimeiHistorico::query()->where([
            'inicio' => $periodo['inicio'],
            'fim' => $periodo['fim'],
            'cnpj' => $empresa->cnpj,
        ])->sole()->empresa()->sole());
    }
});
