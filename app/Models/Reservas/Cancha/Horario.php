<?php

namespace App\Models\Reservas\Cancha;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    // Define the table associated with the model
    protected $table = 'CANCHA.HORARIO';

    // Define the primary key column name
    protected $primaryKey = 'HORA_CODIGO';
    public $timestamps = false;
    // Define the fillable columns
    protected $fillable = [
        'HORA_CODIGO',
        'CAMP_CODIGO',
        'HORA_FECHA',
        'HORA_PRECIO',
        'HORA_CODPAGO',
        'HORA_INICIO',
        'HORA_FINAL',
        'HORA_BLOQUEO_HASTA',
        'HORA_FECHING',
        'HORA_OPERADOR',
        'HORA_ESTADO'
    ];

}