<?php
namespace App\Models\Reservas\Talleres;

use Illuminate\Database\Eloquent\Model;

class Horarios extends Model
{
    protected $table = 'TALLER.HORARIOS';
    protected $primaryKey = 'HORA_CODIGO';
    public $timestamps = false;
}
