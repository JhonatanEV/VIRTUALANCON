<?php

namespace App\Models\Reservas\Cancha;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'CANCHA.RESERVA';

    protected $primaryKey = 'RESE_CODIGO';
    public $timestamps = false;
}