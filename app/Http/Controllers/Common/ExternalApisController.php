<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Services\OpenStreet;
use App\Services\ViaCep;
use App\Services\ViaCepService;
use Illuminate\Http\Request;

class ExternalApisController extends Controller
{
    // Injeção de dependência
    public function __construct(
        protected ViaCep $viaCepService,
        protected OpenStreet $openStreetService
    ) {}

    // Função para consultar o CEP
    public function cep($cep)
    {
        // Chama o serviço de consulta de CEP
        $dados = $this->viaCepService->consultarCep($cep);

        // Verifica se houve erro na consulta
        if (isset($dados->erro) && $dados->erro) {
            return response()->json([
                'error' => $dados['message']
            ], 400);
        }

        // Retorna os dados do endereço
        return response()->json($dados);
    }

    public function address(Request $request)
    {
        // Chama o serviço de consulta de CEP
        $dados = $this->openStreetService->address($request->address);

        // Verifica se houve erro na consulta
        if (isset($dados->erro) && $dados->erro) {
            return response()->json([
                'error' => $dados['message']
            ], 400);
        }

        // Retorna os dados do endereço
        return response()->json($dados);
    }
}
