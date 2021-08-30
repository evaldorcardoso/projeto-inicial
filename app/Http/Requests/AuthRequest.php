<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
}
