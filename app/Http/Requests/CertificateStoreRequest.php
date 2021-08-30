<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\isPemFileRule;

class CertificateStoreRequest extends FormRequest
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
     * Obtém as regras de validação para salvar um certificado
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => ['required',new isPemFileRule]
        ];
    }

    /**
     *  Define as mensagens personalizadas de validação para cada regra
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'file.required' => 'É necessário informar o arquivo do certificado .pem',
        ];
    }
}
