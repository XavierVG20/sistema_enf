<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsumoRequest extends FormRequest
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
            'nombre'=>'required|min:5|max:30',
            'descripcion'=>'min:5|max:50',

            'unidad'=>'numeric',
        ];
    }

    public function messages()
    {
        return [

        'nombre.required'    =>  'El campo :attribute  es obligatoria.',
        'nombre.min'        => 'El campo :attribute debe contener mas un caracter.',
        'nombre.max'        => 'El campo :attribute debe contener max 30 letras.',
 
        'unidad.numeric'   => 'El campo :attribute de contener solo numeros.',

        
        'descripcion.min'        => 'El campo :attribute debe contener mas de un caracter.',
        'descripcion.max'        => 'El campo :attribute debe contener max 50 caracteres.',
        ];
    }

    public function attributes()
    {
        return [
            'nombre'        => 'nombre',
            'unidad'        => 'unidad',
            'descripcion'    => 'descripcion',
        ];
    }
}
