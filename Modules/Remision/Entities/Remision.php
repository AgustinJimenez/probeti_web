<?php namespace Modules\Remision\Entities;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Input;
use stdClass;

class Remision extends Model
{

    protected $table = 'remision__remisions';
    public $translatedAttributes = [];
    protected $fillable = 
    [
        'obra_id', 
        'fecha_remision', 
        'numero_remision', 
        'estado', 
        'terminado',
        'area'
    ];

    public function obra()
    {
        return $this->belongsTo('Modules\Obras\Entities\Obras', 'obra_id');
    }

    public function detalles()
    {
        return $this->hasMany('Modules\Remision\Entities\RemisionDetalle', 'remision_id');
    }

    public function detalles_facturas()
    {
        return $this->hasMany(\FacturaDetalle::class, 'remision_id');
    }

    //protected $appends = ['fecha_remision'];

    public function getFechaRemisionAttribute()
    {
        $date = $this->attributes['fecha_remision'];
        $dateObject = DateTime::createFromFormat('Y-m-d', $date);
        return $dateObject->format('d/m/Y');
    }

    public function datos_probetas($value = null)
    {
        $probetas = $this->detalles;
        $detalles_facturas = $this->detalles_facturas->filter(function($detalle_factura)
                                                        {
                                                            return (!$detalle_factura->factura->anulado);
                                                        });
        $clasificaciones = ["chicas"=> null, "medianas" => null, "grandes" => null];
        $retiradas = $ensayadas = $facturadas = $por_cobrar = $por_ensayar = $clasificaciones;

        $retiradas['chicas'] = $probetas->where('size_clasification', 'Chica')->count();
        $retiradas['medianas'] = $probetas->where('size_clasification', 'Mediana')->count();
        $retiradas['grandes'] = $probetas->where('size_clasification', 'Grande')->count();

        $facturadas['chicas'] = $detalles_facturas->where('probeta_tipo', 'chica')->sum('cantidad');
        $facturadas['medianas'] = $detalles_facturas->where('probeta_tipo', 'mediana')->sum('cantidad');
        $facturadas['grandes'] = $detalles_facturas->where('probeta_tipo', 'grande')->sum('cantidad');

        $por_cobrar['chicas'] = $retiradas['chicas'] - $facturadas['chicas'];
        $por_cobrar['medianas'] = $retiradas['medianas'] - $facturadas['medianas'];
        $por_cobrar['grandes'] = $retiradas['grandes'] - $facturadas['grandes'];
//ENSAYADAS NUMBER
        $ensayadas['chicas'] = $probetas->where('size_clasification', 'Chica')->filter(function($probeta)
                                                                                {
                                                                                    if($probeta->resistencia && $probeta->resistencia > 0)
                                                                                        return true;
                                                                                })->count();
        $ensayadas['medianas'] = $probetas->where('size_clasification', 'Mediana')->filter(function($probeta)
                                                                                {
                                                                                    if($probeta->resistencia && $probeta->resistencia > 0)
                                                                                        return true;
                                                                                })->count();
        $ensayadas['grandes'] = $probetas->where('size_clasification', 'Grande')->filter(function($probeta)
                                                                                {
                                                                                    if($probeta->resistencia && $probeta->resistencia > 0)
                                                                                        return true;
                                                                                })->count();
//POR ENSAYAR NUMBER
        $por_ensayar['chicas'] = $retiradas['chicas'] - $ensayadas['chicas'];
        $por_ensayar['medianas'] = $retiradas['medianas'] - $ensayadas['medianas'];
        $por_ensayar['grandes'] = $retiradas['grandes'] - $ensayadas['grandes'];

        $datos_probetas = collect(["retiradas" => $retiradas, "ensayadas" => $ensayadas, "facturadas" => $facturadas, "por_cobrar" => $por_cobrar, "por_ensayar" => $por_ensayar]);

        if($value)
            return $datos_probetas[$value];
        else
            return $datos_probetas;
    }

    
    
    

    /* =========================================================
        obtiene en un array a las clasificaciones como index 
        y como valor a sus cantidades
    */
    public function getClasificacionCantidadesAttribute()
    {
        $detalles = $this->detalles;
        $chicas = $medianas = $grandes = 0;
        foreach ($detalles as $key => $detalle) 
            if($detalle->size_clasification == "Chica")
                $chicas++;
            else if($detalle->size_clasification == "Mediana")
                $medianas++;
            else
                $grandes++;

        return $cantidad_clasificaciones = 
        [
            "chicas" => $chicas,
            "medianas" => $medianas,
            "grandes" => $grandes
        ];
    }
    /* =========================================================
        se envia 'chicas' o 'medianas' o 'grandes' y se obtiene
        la cantidad de la clasificacion
    */
    public function cantidad_clasificacion($clasificacion = '')
    {
        return $this->clasificacion_cantidades[$clasificacion];
    }
    public function cantidades_tipos_probetas()
    {
        $object = new stdClass;
        $object->chicas = $this->clasificacion_cantidades['chicas'];
        $object->medianas = $this->clasificacion_cantidades['medianas'];
        $object->grandes = $this->clasificacion_cantidades['grandes'];
        return $object;
    }
    public function scopeFilter($query)
    {
        $query->join('obras__obras','obras__obras.id','=','remision__remisions.obra_id')
              ->join('clientes__clientes','clientes__clientes.id','=','obras__obras.cliente_id');


        if ( Input::has('inputCliente') && trim(Input::get('inputCliente') !== '') ) 
        {
            $query->where('clientes__clientes.nombre', 'LIKE', trim('%' . Input::get('inputCliente')) . '%');
        }

        if ( Input::has('inputObra') && trim(Input::get('inputObra') !== '') ) 
        {
            $query->where('obras__obras.nombre', 'LIKE', trim('%' . Input::get('inputObra')) . '%');
        }
        
        if ( Input::has('selectEstado') && trim(Input::get('selectEstado') !== '') ) 
        {
            $query->where('estado', 'LIKE', trim('%' . Input::get('selectEstado')) . '%');
        }
        if ( Input::has('selectTerminado') && trim(Input::get('selectTerminado') !== '') ) 
        {
            $query->where('terminado', 'LIKE', trim('%' . Input::get('selectTerminado')) . '%');
        }  
        if ( Input::has('inputNroRemision') && trim(Input::get('inputNroRemision') !== '') ) 
        {
            $query->where('numero_remision', 'LIKE', trim('%' . Input::get('inputNroRemision')) . '%');
        }                      
 
        $query->select('remision__remisions.*');
        return $query;
    }




}
