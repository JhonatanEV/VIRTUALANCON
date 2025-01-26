<?php

namespace App\Models\Casilla;
use Illuminate\Database\Eloquent\Model;

class Adjunto extends Model
{
    protected $table = 'CASILLA.ADJUNTO';

    protected $primaryKey = 'ADJNTO_CODIGO';

    public $keyType = 'int';

    public $timestamps = false;

    public $incrementing = true;

    protected static function boot()
    {
        parent::boot();
    }

}
