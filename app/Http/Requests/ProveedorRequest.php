<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
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
            'nombre'    =>      'required',
            // 'tipo_documento'    =>  'required',
             'num_documento'=>'required|numeric',
             'direccion'     =>     'required|',
             'telefono'      =>      'required|',
             'email'     =>      'required|email',
             'contacto'     =>    'required',
             'telefono_contacto' =>     'required'
        
        ];
    }
    public function messages()
    {
        return [

        'nombre.required'    =>  'El campo :attribute  es obligatoria.',

        'num_documento.rquired'   => 'El campo :attribute es obligatoria.',
        'num_documento.numeric'   => 'El campo :attribute de contener solo numeros.',

        'direccion.required'        => 'El campo :attribute es obligatoria.',

        'telefono.required'        => 'El campo :attribute es obligatoria.',

        'email.required'        => 'El campo :attribute es obligatoria.',
        'email.email'        => 'El campo :attribute no es un admitido.',
        'contacto.required'    =>  'El campo :attribute  es obligatoria.',
        'telefono_contacto.required'    =>  'El campo :attribute  es obligatoria.',



        ];
    }

    public function attributes()
    {
        return [
            'nombre'        => 'nombre',
            'num_documento'        => 'numero de documento',
            'direccion' => 'direccion',
            'telefono'        => 'telefono',
            'email'    => 'email',
            'contacto'    => 'contacto',
            'telefono_contacto'    => 'telefono del contacto',
        ];
    }
}
