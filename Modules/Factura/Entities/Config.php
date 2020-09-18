<?php

namespace Modules\Factura\Entities;

use Illuminate\Database\Eloquent\Model;
class Config extends Model
{
    protected $table = 'config_factura';
    public $translatedAttributes = [];
    protected $fillable = [
        'identificador', 'nombre', 'valor'
    ];

}