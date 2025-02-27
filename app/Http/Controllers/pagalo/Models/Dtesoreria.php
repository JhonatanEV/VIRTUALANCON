<?php
namespace App\Http\Controllers\pagalo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dtesoreria extends Model
{
    protected $table = 'tesoreria.dtesore';

    protected $primaryKey = 'idsigma';

    public $keyType = 'string';

    public $timestamps = false;

    public $incrementing = true;
    
    protected $fillable = [
        'idsigma',
        'cnumcom',
        'ciduser',
        'cidpers',
        'nnroope',
        'dfecpag',
        'dnrodoc',
        'ctippag',
        'nestado',
        'nmontot',
        'vhostnm',
        'vusernm',
        'ddatetm',
        'cnumope'
    ];
}