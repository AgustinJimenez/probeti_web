<?php

namespace Modules\Remision\Http\Requests;

use App\Http\Requests\Request;

class RemisionRequest extends Request
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
            'obra_id' => 'required',
            'fecha_remision' => 'required',
            'numero_remision' => 'required',
        ];

        foreach($this->request->get('numero_probeta') as $key => $val)
        {
            $rules['numero_probeta.'.$key] = 'required';
            $rules['fecha_moldeo.'.$key] = 'required';
            $rules['dias.'.$key] = 'required';
            $rules['obs1.'.$key] = 'required';
        }

        return $rules;
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [
            'obra_id.required' => 'La obra es requerida',
            'fecha_remision.required' => 'La fecha remision es requerida',
            'numero_remision.required' => 'El numero de remision es requerida'];
        foreach($this->request->get('numero_probeta') as $key => $val)
        {
            $messages['numero_probeta.'.$key.'.required'] = 'El numero de probeta es requerido';
            $messages['fecha_moldeo.'.$key.'.required'] = 'La fecha de moldeo es requerida';
            $messages['dias.'.$key.'.required'] = 'Los dias son requeridos';
            $messages['obs1.'.$key.'.required'] = 'La pieza mixer es requerido';
        }

        return $messages;
    }
}
