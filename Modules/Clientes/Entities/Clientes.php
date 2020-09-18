<?php namespace Modules\Clientes\Entities;

use Illuminate\Database\Eloquent\Model;
class Clientes extends Model
{

    protected $table = 'clientes__clientes';
    protected $fillable = [
        'nombre',
        'ruc',
        'telefono',
        'celular',
        'email',
        'direccion',
        'contacto',
        'razon_social'
    ];

    /**
     * Trae ordenado por nombre
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivo($query)
    {
        return $query->orderBy('nombre','DESC');
    }
    public function obra()
    {
        return $this->hasOne( \Obra::class , "id");
    }

    public function obras()
    {
        return $this->hasMany(\Obra::class , "cliente_id");
    }
}
