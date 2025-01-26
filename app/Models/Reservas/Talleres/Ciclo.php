<?php
namespace App\Models\Reservas\Talleres;

use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    // Define the table associated with the model
    protected $table = 'TALLER.CICLO';

    // Define the primary key column name
    protected $primaryKey = 'CICLO_CODIGO';

    // Define the fillable columns
    protected $fillable = [
        // Add your fillable columns here
    ];

    public $timestamps = false;

    function AperturaCurso()
    {
        return $this->belongsTo(CursoApertura::class, 'CICLO_CODIGO' , 'CICLO_CODIGO');
    }

}