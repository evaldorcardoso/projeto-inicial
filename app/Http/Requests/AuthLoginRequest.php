<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
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
     * Obtém as regras de validação para logar um usuário
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['email', 'required'],
            'password' => ['min:8', 'required']
        ];
    }

    /**
     * Define as mensagens personalizadas de validação para cada regra
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Email é obrigatório',
            'email.email' => 'Este email parece estar incorreto',
            'password.required' => 'Senha é obrigatória',
            'password.min' => 'Senha deve ter no mínimo 8 caracteres'
        ];
    }
}
