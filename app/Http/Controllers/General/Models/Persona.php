<?php
namespace App\Http\Controllers\General\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Seguridad\Models\Usuarios;

class Persona extends Model
{
    protected $table = 'virtual.PERSONA';
    protected $primaryKey = 'PERS_CODIGO';
    public $timestamps = false;

    public function usuario()
    {
        return $this->hasOne(Usuarios::class, 'PERS_CODIGO', 'PERS_CODIGO');
    }
}