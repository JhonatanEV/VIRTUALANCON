<?php
namespace App\Http\Controllers\Seguridad\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Seguridad\Models\Permisos;
class Perfil extends Model
{
    protected $table = 'virtual.PERFIL';
    protected $primaryKey = 'PERF_CODIGO';
    public $timestamps = false;

    public function permisos()
    {
        return $this->hasMany(Permisos::class, 'PERF_CODIGO', 'PERF_CODIGO')->where('PERM_ESTADO', 1);
    }
}