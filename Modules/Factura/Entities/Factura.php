<?php namespace Modules\Factura\Entities;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Input;
class Factura extends Model
{

    protected $table = 'factura__facturas';
    public $translatedAttributes = [];
    protected $fillable = [
        'id',
        'razon_social',
        'ruc',
        'fecha',
        'direccion',
        'telefono',
        'forma_de_pago',
        'monto_total',
        'monto_total_letras',
        'iva_5_total',
        'iva_10_total',
        'iva_total',
        'anulado',
        'observacion',
        'nro_factura',
        'cobrado',
        'detalle_pago',
        'orden_compra',
        'cliente_id'
    ];

    public function remision()
    {
        return $this->belongsTo('Modules\Remision\Entities\Remision', 'remision_id');
    }
    public function detalles()
    {
        return $this->hasMany( FacturaDetalle::class, "factura_id");
    }

    public function getFechaAttribute()
    {
        $date = $this->attributes['fecha'];
        $dateObject = DateTime::createFromFormat('Y-m-d', $date);
        return $dateObject->format('d/m/Y');
    }
    public function remove_dots($value)
    {
        return str_replace('.', '', $value);
    }

    public function unformat_attributes()
    {
        $this->fecha = date("Y-m-d", strtotime( str_replace('/', '-', $this->attributes['fecha']) ));
        $this->monto_total = $this->remove_dots( $this->monto_total );
        $this->iva_5_total = $this->remove_dots( $this->iva_5_total );
        $this->iva_10_total = $this->remove_dots( $this->iva_10_total );
        $this->iva_total = $this->remove_dots( $this->iva_total );
        $this->anulado = (int)$this->anulado;
        $this->cobrado = (int)$this->cobrado;
        return $this;
    }
    public function scopeFilter($query)
    {
        //$query->with('remision.obra.cliente');

        $query->join('remision__remisions','remision__remisions.id','=','remision_id')
              ->join('obras__obras','obras__obras.id','=','remision__remisions.obra_id')
              ->join('clientes__clientes','clientes__clientes.id','=','obras__obras.cliente_id');




        //dd($query->get());

        if ( Input::has('inputCliente') && trim(Input::get('inputCliente') !== '') ) 
        {
            $query->where('clientes__clientes.razon_social', 'LIKE', trim('%' . Input::get('inputCliente')) . '%');
        }

        if ( Input::has('fecha_inicio') && trim(Input::get('fecha_inicio') !== '') ) 
        {
            $query->where('fecha', '>=', date_create_from_format('d/m/Y',Input::get('fecha_inicio'))->modify('-1 day')  );
        }

        //dd($query->get(['fecha']));

        if ( Input::has('fecha_fin') && trim(Input::get('fecha_fin') !== '') ) 
        {
            $query->where('fecha', '<=', date_create_from_format('d/m/Y',Input::get('fecha_fin')) );
        }                  
 
        $query->select('factura__facturas.*')->groupBy('factura__facturas.id');

        //dd($query->get());

        return $query;
    }
}
