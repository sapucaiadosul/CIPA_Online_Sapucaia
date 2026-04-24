<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CadastroUsuarioRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'cpf' => ['required','unique:users','cpf'],
            'password' => 'confirmed|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'O email informado já está em uso, registre outro email!',
            'password.confirmed' => 'As senhas não coincidem!',
            'cpf.cpf' => 'Informe um CPF válido!',
            'cpf.unique' => 'O CPF informado já está cadastrado no sistema',
            'password.min' => 'A senha precisa ter pelo menos 8 caracteres!',
            'password_confirmation.min' => 'A senha precisa ter ao menos 8 caracteres!',
        ];
    }
}