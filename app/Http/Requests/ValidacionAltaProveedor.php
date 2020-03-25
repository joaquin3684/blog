<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionAltaProveedor extends FormRequest
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
            'cuit' => 'required|unique:proovedores,cuit,'.$this->get('id'),
            'razon_social' => 'required|unique:proovedores,razon_social,'.$this->get('id'),
            'email' => 'required|unique:users,email',
            'domicilio' => 'required',
            'telefono' => 'required',
            'id_prioridad' => 'required',
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
