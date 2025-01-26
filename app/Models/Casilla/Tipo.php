<?php
namespace App\Models\Casilla;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'CASILLA.TIPO';

    protected $primaryKey = 'TIPO_CODIGO';

    public $keyType = 'int';

    public $timestamps = false;

    public $incrementing = true;
    
    protected $fillable = [
    ];

}