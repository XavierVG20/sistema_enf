<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
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
        'nombre'        => 'required|min:5|max:30',
        ];
    }

    public function messages()
    {
        return [
        'nombre.required'   => 'El campo :attribute es obligatorio.',
        'nombre.min'        => 'El campo :attribute debe contener mas de una letra.',
        'nombre.max'        => 'El campo :attribute debe contener max 30 letras.',
 
   
 
        ];
    }
    public function attributes()
    {
        return [
            'nombre'        => 'nombre',
        ];
    }
}
