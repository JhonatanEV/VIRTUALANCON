<?php
namespace App\Http\Controllers\pagalo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contrib extends Model
{
    protected $connection = 'sqlsrv_rentas';
    protected $table = 'dbo.CONTRIB';

    protected $primaryKey = 'FACODCONTR';

    public $keyType = 'varchar';

    public $timestamps = false;

    public $incrementing = true;
    
    protected $fillable = [
    ];
    
    public function direccion()
    {
        $contribuyente = $this->FACODCONTR;
        $direccion = DB::connection($this->connection)
                    ->select("SET NOCOUNT ON; SELECT dbo.f_obtner_domfiscal_contrib('$contribuyente') AS direccion")[0]->direccion;
        return $direccion ?? 'No se encontró dirección';
    }
}