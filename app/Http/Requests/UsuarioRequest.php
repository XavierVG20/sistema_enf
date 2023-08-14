<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
            
       
                'name'    =>      'required',
               // 'tipo_documento'    =>  'required',
                'num_documento'=>'required|numeric',
                'idrol'     =>  	'required|min:1',
                'direccion'     =>     'required|',
                'telefono'      =>      'required|',
                'email'     =>      'required|email',
                'password'      =>  'required'
        
        ];
    }

    public function messages()
    {
        return [

        'name.required'    =>  'El campo :attribute  es obligatoria.',

        'num_documento.required'   => 'El campo :attribute es obligatoria.',
        'num_documento.numeric'   => 'El campo :attribute de contener solo numeros.',

        'idrol.rquired'   => 'El campo :attribute es obligatoria.',
        'idrol.min'   => 'El campo :attribute debe contener un rol.',

        'direccion.required'        => 'El campo :attribute es obligatoria.',

        'telefono.required'        => 'El campo :attribute es obligatoria.',

        'email.required'        => 'El campo :attribute es obligatoria.',
        'email.email'        => 'El campo :attribute no es admitido.',
        'password.required'    =>  'El campo :attribute  es obligatoria.',

        ];
    }

    public function attributes()
    {
        return [
            'name'        => 'nombre',
            'num_documento'        => 'numero de documento',
            'direccion' => 'direccion',
            'telefono'        => 'telefono',
            'email'    => 'email',
            'password'    => 'password',

        ];
    }
}
