<?php

namespace App\Traits;

use App\Models\Auditoria;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait AuditoriaTrait
{
    use UtilsTrait;

    public function store(Model $model, $event, $data = [])
    {
        $auditoria = new Auditoria();
        $auditoria->COD_EMP = $model->COD_EMP;
        $auditoria->FEC_EVENTO = Carbon::now()->format('Y-m-d H:i');
        $auditoria->TIP_EVENTO = $event;
        $auditoria->COD_USUARIO = Auth::check() ? Auth::user()->COD_USUARIO : 'ADMIN';
        $auditoria->DES_OBJETO = $model->getTable();
        $auditoria->COD_IDENTIFICADOR = json_encode($model->auditoria_key);
        $auditoria->DET_REGISTRO = json_encode($data);
        $auditoria->NUM_IP = $this->getIpCliente();
        $auditoria->NOM_USUARIOPC = gethostbyaddr($this->getIpCliente());
        $auditoria->COD_USUARIOBD = DB::connection()->getConfig('username');
        $auditoria->NOM_EQUIPO = $_SERVER['SERVER_ADDR'];
        $auditoria->save();
    }
}
