<?php

namespace MLMendes\LaravelReceitaWS;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use MLMendes\LaravelReceitaWS\Models\Empresa;
use MLMendes\LaravelReceitaWS\Models\ReceitaWS as ReceitaWSModel;
use MLMendes\LaravelReceitaWS\Enum\Fallback;

class ReceitaWS
{
    public function receitaFederal(ReceitaWSModel $receitaWS, string $cnpj, int $days = 0, Fallback $fallback = Fallback::CACHE_ON_ERROR)
    {
        $response = Http::acceptJson()->withToken($receitaWS->token)
            ->get("https://receitaws.com.br/v1/cnpj/{$cnpj}/days/{$days}", [
                'fallback' => $fallback->value
            ]);

        Log::debug($response);
    }

    public function cadastroDeContribuinte(ReceitaWSModel $receitaWS, string $cnpj, int $days = 0, Fallback $fallback = Fallback::CACHE_ON_ERROR)
    {
        $response = Http::acceptJson()->withToken($receitaWS->token)
            ->get("https://receitaws.com.br/v1/ccc/{$cnpj}/days/{$days}", [
                'fallback' => $fallback->value
            ]);

        Log::debug($response);
    }

    public function simplesNacional(ReceitaWSModel $receitaWS, string $cnpj, int $days = 0, Fallback $fallback = Fallback::CACHE_ON_ERROR)
    {
        $response = Http::acceptJson()->withToken($receitaWS->token)
            ->get("https://receitaws.com.br/v1/simples/{$cnpj}/days/{$days}", [
                'fallback' => $fallback->value
            ]);

        Log::debug($response);
    }
}