<?php

namespace App\Models\Reservas\Talleres;

use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    protected $table = 'TALLER.PROGRAMACION';
    protected $primaryKey = 'PROG_CODIGO';
    public $timestamps = false;

    function Horarios()
    {
        return $this->hasMany(Horarios::class, 'PROG_CODIGO', 'PROG_CODIGO');
    }
}