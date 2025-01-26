<?php

namespace App\Http\Controllers\Seguridad\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\EncryptionService;

class UsuaEmpresasResponse extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'uemp_codigo' => $this->UEMP_CODIGO,
            'empr_codigo' => $this->EMPR_CODIGO,
            'empr_nombre' => $this->empresa ? $this->empresa->EMPR_NOMBRE : '',
            'empr_abrev' => $this->empresa ? $this->empresa->EMPR_ABREV : '',
            'empr_direccion' => $this->empresa ? $this->empresa->EMPR_DIRECCION : '',
            'empr_logo' => $this->empresa ? $this->empresa->EMPR_LOGO : '',
            'estado' => $this->UEMP_ESTADO,
        ];

        return array_merge($data, [
            'encryp' => EncryptionService::encryptAttribute($data,true)
        ]);
    }
}