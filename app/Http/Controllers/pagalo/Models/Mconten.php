<?php
namespace App\Http\Controllers\pagalo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mconten extends Model
{
    protected $table = 'public.mconten';

    protected $primaryKey = 'idsigma';

    public $keyType = 'string';

    public $timestamps = false;

    public $incrementing = true;

    protected $fillable = [
        'ctipdoc',
        'vdescri',
        'vobjeto',
        'vobserv',
        'cidtabl',
        'ctipdat',
        'nlongit',
        'ndecima',
        'vdefaul',
        'nnregis',
        'nestado',
        'vhostnm',
        'vusernm',
        'ddatetm',
        'vcodmig',
        'viconos',
        'nordens',
        'vnovisiblerecibo'
    ];
}