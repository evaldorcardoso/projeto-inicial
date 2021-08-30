<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
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
     * Obtém as regras de validação para o registro de um usuário
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required','max:255'],
            'email' => ['email', 'required', 'unique:users'],
            'cpf' => ['required', 'min:11', 'max:11', 'unique:users'],
            'phone_1' => ['nullable', 'min:8', 'max:255'],
            'phone_2' => ['nullable', 'min:8', 'max:255'],
            'born_date' => ['date', 'required'],
            'password' => ['min:8', 'max:255', 'required','confirmed'],
            'address' => ['required', 'min:5', 'max:255']
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
            'name.required' => 'Nome é obrigatório!',
            'email.required' => 'Email é obrigatório!',
            'email.unique' => 'Este email já está sendo usado!',
            'email.email' => 'Este email parece estar incorreto!',
            'cpf.required' => 'CPF é obrigatório',
            'cpf.min' => 'CPF deve ter 11 caracteres',
            'cpf.max' => 'CPF deve ter 11 caracteres',
            'cpf.unique' => 'Este CPF já está sendo usado',
            'born_date.date' => 'Data de nascimento não parece uma data válida',
            'password.required' => 'Senha é obrigatório',
            'password.min' => 'Senha deve ter no mínimo 8 caracteres',
            'address.required' => 'Endereço é obrigatório',
            'address.min' => 'Informe o endereço completo'
        ];
    }
}
