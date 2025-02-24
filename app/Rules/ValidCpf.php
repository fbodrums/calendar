<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCpf implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/\D/', '', $value);

        // Verifica se tem 11 dígitos
        if (strlen($cpf) != 11) {
            $fail('O CPF informado não é válido, é preciso ter 11 números.');
            return;
        }

        // Elimina CPFs inválidos conhecidos (exemplo: 111.111.111-11)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $fail('O CPF não pode ser validado');
            return;
        }

        // Calcula os dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$t] != $d) {
                $fail('O CPF informado não é válido.');
                return;
            }
        }
    }
}
