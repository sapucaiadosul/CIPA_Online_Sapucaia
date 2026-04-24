<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidatoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email:rfc,dns', 'ends_with:com,net,org,br,gov,edu,mil,biz'],
            'apelido' => ['required'],
            'telefone' => ['required']
        ];
    }
    

    public function messages()
    {
        return [
            'telefone.required' => 'Por favor insira um telefone!',
            'apelido.required' => 'Por favor insira um apelido!',
            'email.required' => 'Por favor insira um email!',
            'email.email' => 'O email inserido é invalido!',
            'email.ends_with' => 'O email deve ter um domínio válido (com, net, org).' 
        ];
    }
}
