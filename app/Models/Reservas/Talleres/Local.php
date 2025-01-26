<?php
namespace App\Models\Reservas\Talleres;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'TALLER.LOCAL';
    protected $primaryKey = 'LOCAL_CODIGO';
    public $timestamps = false;

}
