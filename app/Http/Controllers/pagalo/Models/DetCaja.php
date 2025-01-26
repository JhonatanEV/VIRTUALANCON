<?php
namespace App\Http\Controllers\pagalo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetCaja extends Model
{
    protected $connection = 'sqlsrv_rentas';
    protected $table = 'dbo.DETCAJA';

    protected $primaryKey = 'FANROOPERA';

    public $keyType = 'varchar';

    public $timestamps = false;

    public $incrementing = true;
    
    protected $fillable = [
    ];
}