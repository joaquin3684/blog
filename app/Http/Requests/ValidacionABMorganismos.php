<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ValidacionABMorganismos extends FormRequest
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
            'nombre' => 'required|unique:organismos,nombre,'.$this->get('id'),
            'cuit' => 'required|unique:organismos,cuit,'.$this->get('id')
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
