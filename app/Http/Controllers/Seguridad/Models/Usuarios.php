<?php

namespace App\Http\Controllers\Seguridad\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\General\Models\Persona;
use App\Http\Controllers\Seguridad\Models\Perfil;
use App\Http\Controllers\Seguridad\Models\Accesos;
use App\Http\Controllers\Seguridad\Models\Permisos;
use App\Http\Controllers\Seguridad\Models\UsaEmpresas;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Usuarios extends Model
{
    // use HasApiTokens, Notifiable;
    use \Awobaz\Compoships\Compoships;
    
    protected $table = 'virtual.USUARIOS';
    protected $primaryKey = 'USUA_CODIGO';
    public $timestamps = false;
    protected $dateFormat = 'd-m-Y H:i:s';
    
    protected $fillable = [
        'PERF_CODIGO',
        'USUA_USERNAME',
        'USUA_PASSWORD',
        'PERS_CODIGO',
        'USUA_FECHING',
        'USUA_ESTADO',
    ];
    protected $casts = [
        'USUA_CODIGO' => 'integer',
    ];
    public function getDateFormat(){
        return 'Y-d-m';
    }
    public static function hashPassword($value)
    {
        return  Hash::make($value);
    }
    public static function generarPassword()
    {
        return strtoupper(Str::random(8));
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'PERS_CODIGO', 'PERS_CODIGO');
    }
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'PERF_CODIGO', 'PERF_CODIGO');
    }
    public function accesos()
    {
        return $this->hasMany(Accesos::class, 'USUA_CODIGO', 'USUA_CODIGO');
    }
    public function usuaEmpresas()
    {
        return $this->hasMany(UsuaEmpresas::class, 'USUA_CODIGO', 'USUA_CODIGO');
    }
    public function assignRolesAndMenus()
    {
        if(Accesos::where('USUA_CODIGO', $this->USUA_CODIGO)->count() == 0) {
            $rolesMenu = Permisos::where('PERF_CODIGO', $this->PERF_CODIGO)->get();
        
            foreach ($rolesMenu as $rolMenu) {
                Accesos::create([
                    'OPCI_CODIGO' => $rolMenu->OPCI_CODIGO,
                    'USUA_CODIGO' => $this->USUA_CODIGO,
                    'ACCE_ESTADO' => $rolMenu->PERM_ESTADO,
                    'ACCE_FECHING' => \Carbon\Carbon::now(),
                    'ACCE_OPERADOR' => $this->USUA_CODIGO,
                    'ACCE_ESTACION' => gethostname(),
                ]);
            }
        }
    }
    public function scopeSearch($query, $request)
    {
        return $query->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        if ($request->usua_estado != null) {
                            $query->where('USUA_ESTADO', $request->usua_estado);
                        }
                    })
                    ->when($request->perf_codigo, function ($query) use ($request) {
                        $query->where('PERF_CODIGO', $request->perf_codigo);
                    })
                    ->when($request->dato, function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->orWhere('USUA_USERNAME', 'like', '%' . ($request->dato) . '%')
                                ->orWhereHas('persona', function ($query) use ($request) {
                                    $query->where('PERS_NOMCOM', 'like', '%' . ($request->dato) . '%');
                                });
                        });
                    });              
            });
    }
}