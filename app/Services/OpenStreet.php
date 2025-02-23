<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Kolirt\Openstreetmap\Facade\Openstreetmap;


class OpenStreet
{
    public function address($address)
    {
        $url = 'https://nominatim.openstreetmap.org/search';

        $userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36";

        $response = Http::withOptions([
            'proxy' => 'http://187.32.246.84:3218' // Exemplo: http://123.456.789.000:8080
        ])->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36',
        ])->get($url, [
            'q' => $address,
            'format' => 'json',
            'limit' => 1
        ]);


        dd($response);

        // Verifica se a consulta foi bem-sucedida
        if ($response->successful()) {
            return $response->json();
        }

        // Caso haja erro na consulta
        return fluent([
            'erro' => true,
            'message' => 'Não foi possível consultar o Endereço.',
        ]);
    }
}
