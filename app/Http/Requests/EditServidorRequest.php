<?php

namespace App\Http\Requests;

use App\Rules\CPFRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EditServidorRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'matricula' => 'required|string|max:10',
            'cpf' => ['required', 'string', 'max:14', new CPFRule],
            'dt_nascimento' => 'required|date',
            'vinculo' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'matricula.required' => 'O campo matrícula é obrigatório',
            'cpf.required' => 'O campo CPF é obrigatório',
            'dt_nascimento.required' => 'O campo data de nascimento é obrigatório',
            'vinculo.required' => 'O campo vínculo é obrigatório'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', $this->cpf),
            'matricula' => preg_replace('/\D/', '', $this->matricula),
        ]);
    }  
}
