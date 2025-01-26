<?php
namespace App\Http\Controllers\Seguridad\Models;
use Illuminate\Database\Eloquent\Model;

class Opciones extends Model
{
    protected $table = 'virtual.OPCIONES';
    protected $primaryKey = 'OPCI_CODIGO';
    public $timestamps = false;
    protected $casts = [
        'OPCI_CODIGO' => 'integer',
        'OPCI_SUB_CODIGO' => 'integer',
        'OPCI_TIPO' => 'integer',
        'OPCI_ESTADO' => 'integer',
    ];

    function subOpcion(){
        return $this->belongsTo(Opciones::class, 'OPCI_SUB_CODIGO', 'OPCI_CODIGO');
    }
    public function subOpciones()
    {
        return $this->hasMany(Opciones::class, 'OPCI_SUB_CODIGO', 'OPCI_CODIGO')
                    ->where('OPCI_ESTADO', 1)
                    ->orderBy('OPCI_ORDER', 'ASC');
    }
    function scopeSearch($query, $request){

        return $query->where(function ($query) use ($request) {
                if ($request->opci_nombre != null) {
                    $query->where('OPCI_NOMBRE', 'like', '%' . $request->opci_nombre . '%');
                }
                if ($request->opci_href != null) {
                    $query->where('OPCI_HREF', 'like', '%' . $request->opci_href . '%');
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->opci_estado != null) {
                    $query->where('OPCI_ESTADO', $request->opci_estado);
                }
            });
    }
    public function scopeConSubmenu($query)
    {
        return $query->withCount(['subOpciones' => function ($q) {
            $q->where('OPCI_TIPO', 4);
        }])->having('sub_opciones_count', '>', 0);
    }
}