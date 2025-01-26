<?php

namespace App\Http\Controllers\General\Models;
use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    use \Awobaz\Compoships\Compoships;
    protected $table = 'virtual.AREAS';
    protected $primaryKey = 'AREA_CODIGO';
    public $timestamps = false;

    protected $casts = [
        'AREA_CODIGO' => 'integer',
        'AREA_SUB_CODIGO' => 'integer',
        'AREA_TIPO' => 'integer',
        'AREA_NOMBRE' => 'string',
        'AREA_ABREV' => 'string',
        'AREA_ORDEN' => 'integer',
        'AREA_ESTADO' => 'integer',
    ];
    
}