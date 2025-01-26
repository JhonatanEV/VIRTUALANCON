<?php
namespace App\Models\Reservas\Talleres;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'TALLER.PROFESOR';
    protected $primaryKey = 'PROF_CODIGO';
    public $timestamps = false;

}
