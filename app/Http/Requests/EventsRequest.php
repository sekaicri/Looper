<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EventsRequest extends FormRequest
{
    
      /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|string|unique:events',
            'fecha'=>'required|date_format:Y-m-d H:i:s'
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
            'date'=>'Debe Contener una fecha',
        ];
    }
}
