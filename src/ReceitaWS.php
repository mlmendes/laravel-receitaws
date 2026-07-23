<?php

namespace MLMendes\LaravelReceitaWS;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use MLMendes\LaravelReceitaWS\Enum\Fallback;
use MLMendes\LaravelReceitaWS\Models\Atividade;
use MLMendes\LaravelReceitaWS\Models\Empresa;
use MLMendes\LaravelReceitaWS\Models\QSA;
use MLMendes\LaravelReceitaWS\Models\ReceitaWS as ReceitaWSModel;
use Throwable;

class ReceitaWS
{
    /**
     * @throws InvalidArgumentException
     *
     * @author Bruno Constantino
     */
    private function validateCNPJ(string $cnpj): string
    {
        $c = preg_replace('/[^A-Z0-9]/', '', strtoupper($cnpj));
        if (strlen($c) !== 14 || preg_match('/^0{14}$/', $c)) {
            throw new InvalidArgumentException('The given CNPJ is invalid.');
        }

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

        throw new InvalidArgumentException('The given CNPJ is invalid.');
    }

    /**
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public function receitaFederal(ReceitaWSModel $receitaWS, string $cnpj, int $days = 0, Fallback $fallback = Fallback::CACHE_ON_ERROR)
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
            'bairro',
            'municipio',
            'uf',
            'email',
            'telefone',
            'efr',
            'situacao',
            'motivo_situacao',
            'situacao_especial',
        ]));

        $data['cnpj'] = preg_replace('/[^A-Z0-9]/', '', $response->json('cnpj'));
        $data['cep'] = preg_replace('/\D/', '', $response->json('cep'));
        $data['abertura'] = Carbon::createFromFormat('d/m/Y', $response->json('abertura'))->format('Y-m-d');
        $data['data_situacao'] = Carbon::createFromFormat('d/m/Y', $response->json('data_situacao'))->format('Y-m-d');
        if (! empty($data['data_situacao_especial'])) {
            $data['data_situacao_especial'] = Carbon::createFromFormat('d/m/Y', $response->json('data_situacao_especial'))->format('Y-m-d');
        }
        $data['capital_social'] = (float) $response->json('capital_social');

        $atividades = [];

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

        $qsa = $response->json('qsa');

        // TODO simei

        // TODO simples

        DB::transaction(function () use ($response, $data, $atividades) {
            Atividade::query()->upsert($atividades, 'code', ['code', 'text']);
            Empresa::query()->upsert($data, 'cnpj', array_keys($data));
            $empresa = Empresa::query()->find($data['cnpj']);

            $empresa->atividadesSecundarias()->sync(array_column(array_filter($atividades, function ($value) use ($data) {
                return $value['code'] !== $data['atividade_principal'];
            }), 'code'));

            QSA::query()->upsert(
                array_map(function ($item) use ($data) {
                    return $item['cnpj'] = $data['cnpj'];
                }, $response->json('qsa')),
                ['cnpj', 'nome'],
                ['cnpj', 'nome', 'qual', 'pais_origem', 'nome_rep_legal', 'qual_rep_legal']
            );
        });
    }

    public function cadastroDeContribuinte(ReceitaWSModel $receitaWS, string $cnpj, int $days = 0, Fallback $fallback = Fallback::CACHE_ON_ERROR)
    {
        $response = Http::acceptJson()
            ->withToken($receitaWS->token)
            ->get("https://receitaws.com.br/v1/ccc/{$cnpj}/days/{$days}", [
                'fallback' => $fallback->value,
            ]);
    }

    public function simplesNacional(ReceitaWSModel $receitaWS, string $cnpj, int $days = 0, Fallback $fallback = Fallback::CACHE_ON_ERROR)
    {
        $response = Http::acceptJson()
            ->withToken($receitaWS->token)
            ->get("https://receitaws.com.br/v1/simples/{$cnpj}/days/{$days}", [
                'fallback' => $fallback->value,
            ]);
    }
}
