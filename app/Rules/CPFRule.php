<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CPFRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpfNumeros = preg_replace('/\D/', '', $value);

        if (strlen($cpfNumeros) !== 11) {
            $fail("Informe um CPF com 11 dígitos", null);
            return;
        }

        if (!$this->verifyCPF($cpfNumeros)) {
            $fail("Informe um CPF válido", null);
        }
    }

    private function verifyCPF(string $cpf)
    {

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($tamanhoBase = 9; $tamanhoBase < 11; $tamanhoBase++) {

            $soma = 0;

            for ($indice = 0; $indice < $tamanhoBase; $indice++) {
                $peso = ($tamanhoBase + 1) - $indice;
                $soma += $cpf[$indice] * $peso;
            }


            $resto = ((10 * $soma) % 11) % 10;


            if ($cpf[$indice] != $resto) {
                return false;
            }
        }

        return true;
    }
}
