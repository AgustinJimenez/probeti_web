<?php

namespace Modules\Factura\Entities;

use Illuminate\Database\Eloquent\Model;

class FacturaDetalle extends Model
{
    protected $table = 'factura__detalle';
    public $translatedAttributes = [];
    protected $fillable = [
        'id',
        'cantidad',
        'descripcion',
        'precio_unitario',
        'precio',
        'sub_total',
        'iva',
        'factura_id',
        'remision_id',
        'probeta_tipo'
    ];
    public function factura()
    {
        return $this->belongsTo(\Factura::class, 'factura_id');
    }
    public function remove_dots($value)
    {
        return str_replace('.', '', $value);
    }
    public function remision()
    {
        return $this->belongsTo( \Remision::class, "remision_id");
    }

    public function unformat_attributes()
    {
        $attributes = ['precio_unitario', 'precio', 'sub_total','remision_id', 'cantidad'];

        foreach ($attributes as $attribute)
            if($attribute == 'cantidad')
                $this[$attribute] = (double)$this[$attribute]?str_replace(',', '.', $this[$attribute]):null;
            else
                $this[$attribute] = $this[$attribute]?$this->remove_dots($this[$attribute]):null;

        return $this;
    }
    public function format_attributes()
    {
        $attributes = ['precio_unitario', 'precio', 'sub_total','remision_id', 'cantidad'];

        foreach ($attributes as $attribute)
            if($attribute == 'cantidad')
                $this[$attribute] = $this[$attribute]?number_format($this[$attribute], 2 ,',', ''):null;
            else
                $this[$attribute] = $this[$attribute]?number_format($this[$attribute], 0 ,'', '.'):null;

        return $this;
    }

}