<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;

class ViaCep
{
    // Função para consultar o ViaCEP
    public function consultarCep(string $cep)
    {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        // Verifica se a consulta foi bem-sucedida
        if ($response->successful()) {
            $enrich = $this->enrichData($cep);
            $data = $response->json();
            $coordinates = [];

            if ($enrich['status'] === 'OK') {
                $coordinates = reset($enrich['results'])['geometry']['location'];
            }

            return [
                ...$data,
                'coordinates' => $coordinates,
                'google' => reset($enrich['results'])
            ];
        }

        // Caso haja erro na consulta
        return fluent([
            'erro' => true,
            'message' => 'Não foi possível consultar o CEP.',
        ]);
    }

    private function enrichData(string $cep): array|null
    {
        // $response = Http::get("https://brasilapi.com.br/api/cep/v2/{$cep}");
        $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json?address=$cep,BR&key=AIzaSyDkrAORsI_ObYG9Yx88NkbO3Ee7hqaDl3s");

        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }
}
