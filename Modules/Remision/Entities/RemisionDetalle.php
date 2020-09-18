<?php
/**
 * Created by PhpStorm.
 * User: rodrigo
 * Date: 11/15/16
 * Time: 1:50 PM
 */

namespace Modules\Remision\Entities;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Input;


class RemisionDetalle extends Model
{
    protected $table = 'remision__detalle';
    public $translatedAttributes = [];
    protected $fillable = 
    [
        'numero_probeta',
        'fecha_moldeo',
        'dias',
        'fck',
        'remision_id',
        'fecha_rotura',
        'carga_aplicada',
        'resistencia',
        'estado',
        'pieza_estructural',
        'diametro',
        'altura',
        'peso',
        'tipo_rotura', 
        'observacion'
    ];
    protected $appends = ['fecha_moldeo','fecha_rotura','carga_aplicada_kg', 'tipo_rotura', 'carga_aplicada', 'resistencia', 'diametro'];

    public function getCargaAplicadaAttribute()
    {
        return (double)$this->attributes['carga_aplicada'];
    }

    public function getResistenciaAttribute()
    {
        return (double)$this->attributes['resistencia'];
    }

    public function getDiametroAttribute()
    {
        return (double)$this->attributes['diametro'];
    }

    public function getTipoRoturaAttribute()
    {
        $tipo_rotura = isset($this->attributes['tipo_rotura'])?$this->attributes['tipo_rotura']:null;
        if(!$tipo_rotura)
            return "S/R";
        else
            return $tipo_rotura;
    }
    public function wformat($attribute = null, $n_decimals = 2, $mil = ".", $decimal = ",")
    {
        if($attribute)
        {
            if($attribute == "resistencia" or $attribute == "carga_aplicada" or $attribute == "fck")
            {
                if(!$this[$attribute]  || (double)$this[$attribute] == 0)
                    {return "S/R";}
                else
                    return number_format( (double)$this[$attribute], $n_decimals, $decimal, $mil);
            }
            else 
                return number_format( (double)$this[$attribute], $n_decimals, $decimal, $mil);
        }
        else
            dd("wformat($attribute = null, $n_decimals = 2, $mil = ".", $decimal = ",")");
    }

    public function format($attribute, $type = 'number', $date_format = 'd/m/Y')
    {
       if($type == 'number')
           return number_format($this[$attribute], 0, '', '.');

       if($type == 'date')
           return DateTime::createFromFormat('Y-m-d', $this[$attribute])->format($date_format);
       
       else
           return ' format_number($attribute, $type=["number","date"]) ';
    }

    public function getObservacionReducidaAttribute()
    {
        $observacion = $this->observacion;
        $max_length = 40;
        return ( strlen( $observacion ) > $max_length) ? str_limit($observacion, $max_length) . '...' : (string)$observacion ;
    }
    public function getFechaMoldeoAttribute()
    {
        $date = $this->attributes['fecha_moldeo'];
        $dateObject = DateTime::createFromFormat('Y-m-d', $date);
        return $dateObject->format('d/m/Y');
    }

    public function getFacturaAnulada()
    {
        $remision = $this->remision;
        $detalles_facturas = $remision->detalles_facturas;
        $detalles_facturas->filter(function($detalle)
                            {
                                return $detalle->factura->anulada;
                            })->count();

        return $detalles_facturas?true:false;
    }
    public function getPorcentajeAttribute()
    {
        return $this->relacion_fck_resistencia;
    }
    public function getRelacionFckResistenciaAttribute()
    {
        $resistencia = $this->resistencia;
        $fck_teorico = $this->fck;

        if(!$fck_teorico || gettype($fck_teorico) == "string" || !$resistencia)
            return 'S/R';

        $porcentaje = ($resistencia*100)/$fck_teorico;
        if( !(double)$porcentaje > 0 )
            return "S/R";
   // dd("(resistencia*100)/fck_teorico {$resistencia}*100/{$fck_teorico} = porcentaje = {$porcentaje} ");
        if( (double)$porcentaje > 1 )
                $porcentaje = number_format($porcentaje, 2, ',', '');
        else
            $porcentaje = $this->check_exponencial($porcentaje);
    //dd("(resistencia*100)/fck_teorico {$resistencia}*100/{$fck_teorico} = porcentaje = {$porcentaje} ");  
        

        return $porcentaje . ' %';
    }
   
    public function getVolumenAttribute()
    {
        $diametro = $this->diametro;
        $altura = $this->altura;
        $radio = $diametro/2;
        $volumen = pi() * pow($radio, 2) * $altura;
        return $volumen;
    }

    public function check_exponencial($value)
    {
        //$value = "8.3544771572372E-345";
        if(str_contains( (string)$value , "E"))
        {
            $n = (int)str_replace("E-", "", substr( (string)$value , strpos( (string)$value, "E")));
            return (double)number_format($value, $n+2, ".", "");
        }
        else
            return number_format($value, 2, ',', '.');
    }

    public function getPesoEspecificoAttribute()
    {
        $volumen = $this->volumen;

        if(!$volumen) return "S/R";

        $peso = $this->peso;

        if(!$peso) return "S/R";

        $peso_especifico = $peso/$volumen;

        if($peso_especifico == 0.0) return "S/R";
   //$peso1 = $peso_especifico;
        $peso_especifico = $peso_especifico/1000;
    //$peso2 = $peso_especifico;
        $peso_especifico = $this->check_exponencial($peso_especifico);
    //dd("{$peso1}/10000 = {$peso2}  convertido = {$peso_especifico}");

        return $peso_especifico;
    }
    /* =========================================================
        retorna la clasificacion de la probeta
    */
    public function getSizeClasificationAttribute()
    {
        $diametro = $this->diametro;
        
        if($diametro < 7.5)
            return "Chica";
        else if( $diametro >= 7.5 and $diametro < 12.5)
            return "Mediana";
        else 
            return "Grande";
    }

    public function getFechaRoturaAttribute()
    {
        $date = $this->attributes['fecha_rotura'];
        $dateObject = DateTime::createFromFormat('Y-m-d', $date);
        return $dateObject->format('d/m/Y');
    }

    public function remision()
    {
        return $this->belongsTo('Modules\Remision\Entities\Remision', 'remision_id');
    }

    public function scopeFilter($query)
    {
        /*$query->join('obras__obras','obras__obras.id','=','remision__remisions.obra_id')
              ->join('clientes__clientes','clientes__clientes.id','=','obras__obras.cliente_id');
        */

        if ( Input::has('remision_id') && trim(Input::get('remision_id') !== '') ) 
        {
            $query->where('remision_id', Input::get('remision_id')  ) ;
        }

        if ( Input::has('fecha_inicio') && trim(Input::get('fecha_inicio') !== '') ) 
        {
            $query->where('fecha_rotura', '>=', date_create_from_format('d/m/Y',Input::get('fecha_inicio'))->modify('-1 day') );
        }
        if ( Input::has('fecha_fin') && trim(Input::get('fecha_fin') !== '') ) 
        {
            $query->where('fecha_rotura', '<=', date_create_from_format('d/m/Y',Input::get('fecha_fin')) );
        }
                  
 
        //$query->select('remision__remisions.*');
        return $query;
    }

    public function getCargaAplicadaKgAttribute()
    {
        $data = $this->carga_aplicada;
        if(!$data)
            return "S/R";
    //$d = $data;
        $data = ( $data * 1000)/9.8067;
    //  dd( " ( {$d} * 1000)/9.8067 = {$data}" );
    //$d2 = $data;
        $data=number_format($data,2,",",".");
    //dd( " ( {$d} * 1000)/9.8067 = {$d2} = {$data}" );
        return $data;
    }




}