<?php

namespace App\Http\Requests;


namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RequestLogin extends FormRequest
{
      /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password'=>'required|string',
            'email'=>'required|string|email',
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
            'required' => 'El campo :attribute es requerido.',
            'unique' => 'El correo ya está registrado.',
            'email' => 'Tiene que ser un correo valido.'
        ];
    }
}
