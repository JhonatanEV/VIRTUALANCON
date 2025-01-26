<?php

namespace App\Http\Controllers\General\Models;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    protected $table = 'virtual.EMPRESAS';
    protected $primaryKey = 'EMPR_CODIGO';
    public $timestamps = false;
    
}