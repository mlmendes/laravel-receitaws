<?php

namespace MLMendes\LaravelReceitaWS;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use MLMendes\LaravelReceitaWS\Enum\Fallback;
use MLMendes\LaravelReceitaWS\Models\ReceitaWSApiConfig;
use RuntimeException;
use Throwable;

class ReceitaWS
{
    protected string $atividadeModel;

    protected string $empresaModel;

    public function __construct()
    {
        $this->atividadeModel = app(ReceitaWSRegistrar::class)->models['atividade'];
        $this->empresaModel = app(ReceitaWSRegistrar::class)->models['empresa'];
    }

    /**
     * @throws InvalidArgumentException
     *
     * @author https://gist.github.com/brunoconstantino
     *
     * @source https://gist.github.com/brunoconstantino/75a7dcdda56317a69e52e72a27446826
     */
    public function validateCNPJ(string $cnpj): string
    {
        $c = preg_replace('/[^A-Z0-9]/', '', strtoupper($cnpj));
        if (strlen($c) === 14 || ! preg_match('/^0{14}$/', $c)) {
            $getCharValue = function ($char) {
                return ($char >= 'A') ? ord($char) - 48 : (int) $char;
            };

            $checkDigit = function ($pos) use ($c, $getCharValue) {
                $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
                $sum = 0;
                for ($i = 0; $i < $pos; $i++) {
                    $sum += $getCharValue($c[$i]) * $b[$i + ($pos === 12)];
                }
                $n = $sum % 11;

                return $c[$pos] == ($n < 2 ? 0 : 11 - $n);
            };

            if ($checkDigit(12) && $checkDigit(13)) {
                return $c;
            }
        }
        throw new InvalidArgumentException('The given CNPJ is invalid.');
    }

    /**
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public function receitaFederal(ReceitaWSApiConfig $receitaWS, string $cnpj, int $days = 0, Fallback $fallback = Fallback::CACHE_ON_ERROR): void
    {
        $cnpj = $this->validateCNPJ($cnpj);

        if ($days < 0) {
            throw new InvalidArgumentException('The days argument must be greater than or equal to zero.');
        }

        $response = Http::acceptJson()
            ->withToken($receitaWS->token)
            ->get("https://receitaws.com.br/v1/cnpj/{$cnpj}/days/{$days}", [
                'fallback' => $fallback->value,
            ]);

        $data = array_intersect_key($response->json(), array_flip([
            'tipo',
            'porte',
            'nome',
            'fantasia',
            'natureza_juridica',
            'logradouro',
            'numero',
            'complemento',
            'bairro',
            'municipio',
            'uf',
            'email',
            'situacao',
            'motivo_situacao',
        ]));

        if (! empty($data['situacao_especial'])) {
            $data['situacao_especial'] = $response->json('situacao_especial');
        }
        if (! empty($data['efr'])) {
            $data['efr'] = $response->json('efr');
        }
        $data['cnpj'] = preg_replace('/[^A-Z0-9]/', '', $response->json('cnpj'));
        $data['cep'] = preg_replace('/\D/', '', $response->json('cep'));
        $data['abertura'] = Carbon::createFromFormat('d/m/Y', $response->json('abertura'))->format('Y-m-d');
        $data['data_situacao'] = Carbon::createFromFormat('d/m/Y', $response->json('data_situacao'))->format('Y-m-d');
        if (! empty($data['data_situacao_especial'])) {
            $data['data_situacao_especial'] = Carbon::createFromFormat('d/m/Y', $response->json('data_situacao_especial'))->format('Y-m-d');
        }
        $data['capital_social'] = (float) $response->json('capital_social');

        $atividades = [];

        $telefones = [];

        foreach (explode('/', $response->json('telefone')) as $telefone) {
            $telefone = preg_replace('/\D/', '', $telefone);

            if (strlen($telefone) === 10) {
                if ((int) $telefone[2] >= 6) {
                    $telefone = substr($telefone, 0, 2).'9'.substr($telefone, 2, 8);
                }
            }

            $telefones[] = [
                'cnpj' => $cnpj,
                'numero' => '55'.$telefone,
            ];
        }

        foreach ($response->json('atividade_principal') as $atividade) {
            $code = preg_replace('/\D/', '', $atividade['code']);
            $atividades[] = [
                'text' => $atividade['text'],
                'code' => $code,
            ];
            $data['atividade_principal'] = $code;
        }

        foreach ($response->json('atividades_secundarias') as $atividade) {
            $code = preg_replace('/\D/', '', $atividade['code']);
            $atividades[] = [
                'text' => $atividade['text'],
                'code' => $code,
            ];
        }

        DB::transaction(function () use ($response, $data, $atividades, $telefones) {
            $this->atividadeModel::query()->upsert($atividades, 'code', ['code', 'text']);
            $this->empresaModel::query()->upsert($data, 'cnpj', array_keys($data));
            $empresa = $this->empresaModel::query()->find($data['cnpj']);

            $empresa->telefones()->upsert($telefones, ['cnpj', 'numero'], ['cnpj', 'numero']);

            $empresa->atividadesSecundarias()->sync(array_column(array_filter($atividades, function ($value) use ($data) {
                return $value['code'] !== $data['atividade_principal'];
            }), 'code'));

            $empresa->quadroSocietarioAdministrativo()->whereNotIn('nome', collect($response->json('qsa'))->pluck('nome')->toArray())->delete();

            $empresa->quadroSocietarioAdministrativo()->upsert(
                $response->json('qsa'),
                ['cnpj', 'nome'],
                ['cnpj', 'nome', 'qual', 'pais_origem', 'nome_rep_legal', 'qual_rep_legal']
            );

            if (empty(array_filter($response->json('simei'), fn ($value) => $value !== null))) {
                $empresa->simei()->delete();
            } else {
                $data = $response->json('simei');

                if (! empty($data['data_opcao'])) {
                    $data['data_opcao'] = Carbon::createFromFormat('d/m/Y', $data['data_opcao'])->format('Y-m-d');
                }
                if (! empty($data['data_exclusao'])) {
                    $data['data_exclusao'] = Carbon::createFromFormat('d/m/Y', $data['data_exclusao'])->format('Y-m-d');
                }

                $empresa->simei()->upsert(
                    $data,
                    ['cnpj'],
                    ['cnpj', 'optante', 'data_opcao', 'data_exclusao', 'ultima_atualizacao']
                );
            }

            if (empty(array_filter($response->json('simples'), fn ($value) => $value !== null))) {
                $empresa->simples()->delete();
            } else {
                $data = $response->json('simples');

                if (! empty($data['data_opcao'])) {
                    $data['data_opcao'] = Carbon::createFromFormat('d/m/Y', $data['data_opcao'])->format('Y-m-d');
                }
                if (! empty($data['data_exclusao'])) {
                    $data['data_exclusao'] = Carbon::createFromFormat('d/m/Y', $data['data_exclusao'])->format('Y-m-d');
                }

                $empresa->simples()->upsert(
                    $data,
                    ['cnpj'],
                    ['cnpj', 'optante', 'data_opcao', 'data_exclusao', 'ultima_atualizacao']
                );
            }
        });
    }

    public function cadastroDeContribuinte(ReceitaWSApiConfig $receitaWS, string $cnpj, int $days = 0, Fallback $fallback = Fallback::CACHE_ON_ERROR): void
    {
        $cnpj = $this->validateCNPJ($cnpj);

        if ($days < 0) {
            throw new InvalidArgumentException('The days argument must be greater than or equal to zero.');
        }

        $response = Http::acceptJson()
            ->withToken($receitaWS->token)
            ->get("https://receitaws.com.br/v1/ccc/{$cnpj}/days/{$days}", [
                'fallback' => $fallback->value,
            ]);

        if ($this->validateCNPJ($response->json('cnpj')) !== $cnpj) {
            throw new RuntimeException('Invalid API response.');
        }

        DB::transaction(function () use ($response, $cnpj) {
            $empresa = $this->empresaModel::query()->find($cnpj);

            $empresa->inscricoesEstaduais()->upsert(
                array_map(function ($value) use ($cnpj) {
                    $value['cnpj'] = $cnpj;
                    if (! empty($value['data_situacao'])) {
                        $value['data_situacao'] = Carbon::createFromFormat('d/m/Y', $value['data_situacao'])->format('Y-m-d');
                    }
                    if (! empty($value['data_atualizacao'])) {
                        $value['data_atualizacao'] = Carbon::createFromFormat('d/m/Y', $value['data_atualizacao'])->format('Y-m-d');
                    }

                    return $value;
                }, $response->json('registros')),
                ['uf', 'ie'],
                ['cnpj', 'uf', 'ie', 'tipo_ie', 'situacao_ie', 'data_situacao', 'regime_icms', 'situacao_cnpj', 'data_atualizacao']
            );
        });
    }

    public function simplesNacional(ReceitaWSApiConfig $receitaWS, string $cnpj, int $days = 0, Fallback $fallback = Fallback::CACHE_ON_ERROR): void
    {
        $cnpj = $this->validateCNPJ($cnpj);

        if ($days < 0) {
            throw new InvalidArgumentException('The days argument must be greater than or equal to zero.');
        }

        $response = Http::acceptJson()
            ->withToken($receitaWS->token)
            ->get("https://receitaws.com.br/v1/simples/{$cnpj}/days/{$days}", [
                'fallback' => $fallback->value,
            ]);

        if ($this->validateCNPJ($response->json('cnpj')) !== $cnpj) {
            throw new RuntimeException('Invalid API response.');
        }

        DB::transaction(function () use ($response, $cnpj) {
            $empresa = $this->empresaModel::query()->find($cnpj);

            $empresa->simples()->upsert([
                'cnpj' => $cnpj,
                'optante' => $response->json('simples')['optante'],
                'data_opcao' => $response->json('simples')['data_opcao'],
            ], 'cnpj', ['cnpj', 'optante', 'data_opcao']);

            $empresa->simplesHistorico()->upsert(
                array_map(function ($value) use ($cnpj) {
                    return [
                        'cnpj' => $cnpj,
                        ...$value,
                    ];
                }, $response->json('simples')['historico']['periodos_anteriores']),
                ['cnpj', 'inicio', 'fim'],
                ['cnpj', 'inicio', 'fim', 'detalhamento']
            );

            $empresa->simei()->upsert([
                'cnpj' => $cnpj,
                'optante' => $response->json('simei')['optante'],
                'data_opcao' => $response->json('simei')['data_opcao'],
            ], 'cnpj', ['cnpj', 'optante', 'data_opcao']);

            $empresa->simeiHistorico()->upsert(
                array_map(function ($value) use ($cnpj) {
                    return [
                        'cnpj' => $cnpj,
                        ...$value,
                    ];
                }, $response->json('simei')['historico']['periodos_anteriores']),
                ['cnpj', 'inicio', 'fim'],
                ['cnpj', 'inicio', 'fim', 'detalhamento']
            );
        });
    }
}
