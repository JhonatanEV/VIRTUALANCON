<?php
namespace App\Models\Casilla;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'CASILLA.CATEGORIA';

    protected $primaryKey = 'CATE_CODIGO';

    public $keyType = 'int';

    public $timestamps = false;

    public $incrementing = true;
    
    protected $fillable = [
    ];

}