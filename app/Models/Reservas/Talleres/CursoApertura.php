<?php
namespace App\Models\Reservas\Talleres;

use Illuminate\Database\Eloquent\Model;

class CursoApertura extends Model
{
    protected $table = 'TALLER.CURSOS_APUERTURA';
    protected $primaryKey = 'C_APER_CODIGO';
    public $timestamps = false;

    function Programacion()
    {
        return $this->belongsTo(Programacion::class, 'C_APER_CODIGO', 'C_APER_CODIGO');
    }
}
