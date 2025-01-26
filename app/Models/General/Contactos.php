<?php

namespace App\Models\General;
use Illuminate\Database\Eloquent\Model;

class Contactos extends Model
{
    protected $table = 'GENERAL.CONTACTOS';

    protected $primaryKey = 'CONTC_CODIGO';

    public $keyType = 'int';

    public $timestamps = false;

    public $incrementing = true;

}
