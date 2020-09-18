<?php

namespace Modules\Clientes\Http\Requests;

use App\Http\Requests\Request;

class ClienteRequest extends Request
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
            'nombre' => 'required',
            'ruc' => 'required',
            'telefono' => 'required|numeric',
            'celular' => 'numeric',
            'email' => 'required|email',
            'direccion' => 'required',
            'contacto' => 'required',
            'razon_social' => 'required'
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'ruc.required' => 'El RUC es requerido',
            'telefono.numeric' => 'El telefono debe ser numerico',
            'telefono.required' => 'El telefono es requerido',
            'celular.numeric' => 'El celular debe ser numerico',
            'email.required' => 'El email es requerido',
            'email.email' => 'No es una direccion de email validad',
            'direccion.required' => 'La direccion es requeridad',
            'contacto.required' => 'El contacto es requerido',
            'razon_social.required' => 'Razon Social es requerida'
        ];
    }
}
