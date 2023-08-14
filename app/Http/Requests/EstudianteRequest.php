<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstudianteRequest extends FormRequest
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
            'curso'    =>  'required',
            'num_documento'=>'required|numeric',
            'direccion'     =>     'required|',
            'rep_nombre'     =>     'required|',
            'rep_documento'=>'required|numeric',

            'telefono'      =>      'required|',
            'email'     =>      'required|email',
        ];
    }
    public function messages()
    {
        return [

        'nombre.required'    =>  'El campo :attribute  es obligatoria.',
        'curso.required'    =>  'El campo :attribute  es obligatoria.',

        'num_documento.required'   => 'El campo :attribute es obligatoria.',
        'num_documento.numeric'   => 'El campo :attribute de contener solo numeros.',

        'direccion.required'        => 'El campo :attribute es obligatoria.',
        'rep_nombre.required'    =>  'El campo :attribute  es obligatoria.',
        'rep_documento.required'   => 'El campo :attribute es obligatoria.',
        'rep_documento.numeric'   => 'El campo :attribute de contener solo numeros.',

        'telefono.required'        => 'El campo :attribute es obligatoria.',

        'email.required'        => 'El campo :attribute es obligatoria.',
        'email.email'        => 'El campo :attribute no es un admitido.',
        ];
    }

    public function attributes()
    {
        return [
            'nombre'        => 'nombre',
            'curso'        => 'curso',
            'num_documento'        => 'numero de documento',
            'direccion' => 'direccion',
            'telefono'        => 'telefono',
            'rep_documento'    => 'numero de documento del',
            'rep_nombre'        => 'nombre del representante',

        ];
    }
}
