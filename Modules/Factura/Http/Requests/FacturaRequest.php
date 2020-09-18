<?php

namespace Modules\Factura\Http\Requests;

use App\Http\Requests\Request;

class FacturaRequest extends Request
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
        foreach ($this['detalles'] as $index => $detalle) 
            foreach ($detalle as $key => $attribute) 
                if($attribute == "")
                    $attribute = null;
        $rules = 
        [
            'cabecera[razon_social]' => 'required',
            'cabecera[ruc]'=> 'required',
            'cabecera[fecha]' => 'required',
            'cabecera[direccion]' => 'required',
            'cabecera[monto_total]' => 'required',
            'cabecera[monto_total_letras]' => 'required',
            'cabecera[iva_5_total]' => 'required',
            'cabecera[iva_10_total]' => 'required',
            'cabecera[iva_total]' => 'required',
            'cabecera[detalle_pago]'=>'required',
        ]; 
        foreach ($this->detalles as $key => $detalle) 
        {
            $rules["detalles[".$key."][descripcion]"] = "required";
            $rules["detalles[".$key."][remision_id]"] = "required";
            $rules["detalles[".$key."][cantidad]"] = "required";
            $rules["detalles[".$key."][precio_unitario]"] = "required";
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
        $messages = 
        [
            'cabecera[razon_social].required' => 'Razon Social es requerido',
            'cabecera[ruc].required' => 'RUC es requerido',
            'cabecera[fecha].required' => 'Fecha es requerido',
            'cabecera[direccion].required' => 'Direccion es requerido',
            'cabecera[monto_total].required' => 'El monto total es requerido',
            'cabecera[monto_total_letras].required' => 'El monto total en letras es requerido',
            'cabecera[iva_5_total].required' => 'El IVA 5% es requerido',
            'cabecera[iva_10_total].required' => 'El IVA 10% es requerido',
            'cabecera[iva_total].required' =>'El IVA Total es requerido',
            'cabecera[detalle_pago].required' => "Detalle de pago es requerido"
        ];
        foreach ($this->detalles as $key => $detalle) 
        {
            $messages["detalles[".$key."][descripcion].required"] = "La descripcion es requerida";
            $messages["detalles[".$key."][remision_id].required"] = "Remision no seleccionada";
            $messages["detalles[".$key."][cantidad].required"] = "La cantidad es requerida";
            $messages["detalles[".$key."][precio_unitario].required"] = "Precio unitario requerido";
        }
        return $messages;
    }
}
