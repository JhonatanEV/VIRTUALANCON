<?php

namespace App\Models\Reservas\Cancha;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'CANCHA.PERSONA';

    protected $primaryKey = 'PERS_CODIGO';
    public $timestamps = false;
}