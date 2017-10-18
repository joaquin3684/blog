<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionABMsocios extends FormRequest
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

    public function rules()
    {
        return [
            'dni' => 'required|unique:socios,nombre,'.$this->get('id'),
            'cuit' => 'required|unique:socios,cuit,'.$this->get('id')
        ];
    }

    public function messages()
    {
        return [
            'unique' => 'El :attribute ya existe',
            'required' => 'El campo :attribute no puede estar vacio'
        ];
    }
}
