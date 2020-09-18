<?php

namespace Modules\Obras\Http\Requests;

use App\Http\Requests\Request;

class ObraRequest extends Request
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
            //'ubicacion' => 'required',
            'residente' => 'required',
            'cliente_id' => 'required',
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
            //'ubicacion.required' => 'La ubicacion es requerido',
            'residente.required' => 'El residente es requerido',
            'cliente_id.required' => 'El cliente es requerido',
        ];
    }
}
