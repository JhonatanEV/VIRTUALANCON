<?php
namespace App\Models\Reservas\Talleres;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'TALLER.MATRICULA';
    protected $primaryKey = 'MATRI_CODIGO';
    public $timestamps = false;

}
