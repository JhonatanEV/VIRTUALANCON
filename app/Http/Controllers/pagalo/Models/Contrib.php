<?php
namespace App\Http\Controllers\pagalo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contrib extends Model
{
    protected $table = 'public.mperson';

    protected $primaryKey = 'idsigma';

    public $keyType = 'varchar';

    public $timestamps = false;

    public $incrementing = true;
    
    protected $fillable = [
    ];

}