<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaDatosRequest extends FormRequest
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
            //
            'nombre_empresa'    =>      'required',
      
             'direccion'     =>     'required|',
             'telefono'      =>      'required|',
             'email'     =>      'required|email',
     
        ];
    }
    public function messages()
    {
        return [

        'nombre_empresa.required'    =>  'El campo :attribute  es obligatoria.',
        'direccion.required'        => 'El campo :attribute es obligatoria.',
        'telefono.required'        => 'El campo :attribute es obligatoria.',
        'email.required'        => 'El campo :attribute es obligatoria.',
        'email.email'        => 'El campo :attribute no es admitido.',

        ];
    }

    public function attributes()
    {
        return [
            'nombre_empresa'        => 'nombre empresa',
            'direccion' => 'direccion',
            'telefono'        => 'telefono',
            'email'    => 'email'

        ];
    }
}
