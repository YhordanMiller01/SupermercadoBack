<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FrutaRequest extends FormRequest
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
        $rules = [
            'tipo'                  => 'required|unique:frutas,tipo',
            'cantidad'              => 'required|numeric|min:1',
            'precio'                => 'required'
        ];

        return $rules;
    }

    /**
     * Obtenga los mensajes de error para las reglas de validación definidas.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'required'        => 'El campo :attribute es obligatorio',
            'numeric'         => 'El campo :attribute debe ser un número',
            'max'             => 'El campo :attribute tiene que ser un tamaño no mayor a :max',
            'min'             => 'El campo :attribute tiene que ser un tamaño como minimo a :min',
        ];
    }
    /**
     * Obtenga atributos personalizados para los errores del validador.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'tipo'                   => 'Tipo requerido',
            'cantidad'               => 'Cantidad es requerido',
            'precio'                 => 'Precio es requerido'
        ];
    }

    /**
     * failedValidation function
     *
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Errores de Validación',
            'code' => 403,
            'data'  => $validator->errors()
        ], 403));

    }
}
