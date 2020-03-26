<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionAltaComercializador extends FormRequest
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
            'email' => 'required|unique:users,email,'.$this->get('id'),
            'dni' => 'required|unique:comercializadores,dni,'.$this->get('id'),
            'telefono' => 'required',
            'porcentaje_colocacion' => 'required',
        ];
    }
}
