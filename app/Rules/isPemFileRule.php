<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class isPemFileRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value->getClientOriginalExtension() === 'pem';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Formato de arquivo não suportado. Formatos aceitos: .pem';
    }
}
