<?php
namespace App\Models\Reservas\Talleres;

use Illuminate\Database\Eloquent\Model;

class Cursos extends Model
{
    protected $table = 'TALLER.CURSOS';

    protected $primaryKey = 'CURS_CODIGO';
    public $timestamps = false;
    protected $fillable = [
        // Add your fillable columns here
    ];

}