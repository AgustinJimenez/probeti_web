<?php namespace Modules\Obras\Entities;

use Illuminate\Database\Eloquent\Model;

class Obras extends Model
{

    protected $table = 'obras__obras';
    public $translatedAttributes = [];
    protected $fillable = [
        'nombre',
        'ubicacion',
        'residente',
        'activo',
        'cliente_id',
        'observacion',
        'diametro',
        'etiqueta'
    ];

    /**
     * Trae todas las obras activas.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivo($query)
    {
        return $query->where('activo', 1);
    }

    public function cliente()
    {
        return $this->belongsTo('Modules\Clientes\Entities\Clientes', 'cliente_id');
    }
    public function remision()
    {
        return $this->hasOne('Modules\Remision\Entities\Remision');
    }

    public function remisiones()
    {
        return $this->hasMany( \Remision::class, "obra_id" );
    }
}
