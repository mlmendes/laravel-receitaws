<?php

use MLMendes\LaravelReceitaWS\Facades\LaravelReceitaWS;
use MLMendes\LaravelReceitaWS\Models\Empresa;
use MLMendes\LaravelReceitaWS\Models\InscricaoEstadual;
use MLMendes\LaravelReceitaWS\Models\ReceitaWSApiConfig;
use MLMendes\LaravelReceitaWS\Tests\Fixtures\ReceitaWSApiFixture;

use function Pest\Laravel\assertModelExists;

test('Inscrições Estaduais creates related models', function () {
    $empresa = Empresa::factory()->create();

    $data = ReceitaWSApiFixture::cadastroDeContribuinteResponse($empresa->cnpj);

    $api = ReceitaWSApiConfig::factory()->create();
    Http::fake(['https://receitaws.com.br/v1/ccc/*' => Http::response($data)]);

    LaravelReceitaWS::cadastroDeContribuinte($api, $empresa->cnpj);

    Http::assertSent(function ($request) use ($api) {
        return $request->hasHeader('Authorization', 'Bearer '.$api->token);
    });

    foreach ($data['registros'] as $inscricaoEstadual) {
        assertModelExists($empresa->inscricoesEstaduais()->where('ie', $inscricaoEstadual['ie'])->sole());
        assertModelExists(InscricaoEstadual::query()->where([
            'ie' => $inscricaoEstadual['ie'],
            'uf' => $inscricaoEstadual['uf'],
        ])->sole()->empresa()->sole());
    }
});
