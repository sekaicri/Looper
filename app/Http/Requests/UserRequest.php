<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
{
    
      /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|string',
            'email'=>'required|string|unique:users|email',
            'password'=>'required|string',
            'nftIdentify'=>'required|string',
            'avatar'=>'required|string'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validación de errores',
            'data'      => $validator->errors()
        ], 400, [], JSON_PRETTY_PRINT));

    }
    public function messages()
    {
        return [
            'required' => 'Todos los campos son requeridos',
            'unique' => 'El campo :attribute ya está registrado.',
            'email' => 'El campo :attribute tiene que ser un correo valido.'
        ];
    }
}
