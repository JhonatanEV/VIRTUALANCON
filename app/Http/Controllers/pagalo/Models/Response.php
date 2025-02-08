<?php
namespace App\Http\Controllers\pagalo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Response extends Model
{
    protected $table = 'virtual.RESPONSE';

    protected $primaryKey = 'ID';

    public $keyType = 'int';
    public $timestamps = false;

    public $incrementing = true;
    
    protected $fillable = [
    ];
}