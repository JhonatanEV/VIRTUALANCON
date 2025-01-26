<?php

namespace App\Http\Controllers\Seguridad\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            
            'USUA_CODIGO' => $this->USUA_CODIGO,
            'USUA_USERNAME' => $this->USUA_USERNAME,
            'USUA_ESTADO' => $this->USUA_ESTADO,
            'PERF_CODIGO' => $this->PERF_CODIGO,
            'PERF_NOMBRE' => $this->perfil->PERF_NOMBRE,
            'PERS_CODIGO' => $this->PERS_CODIGO,
            'PERS_NOMBRE' => $this->persona->PERS_NOMBRE,
            'PERS_APATERNO' => $this->persona->PERS_APATERNO,
            'PERS_AMATERNO' => $this->persona->PERS_AMATERNO,
            'PERS_NOMBRES_COMPLETO' => $this->persona->PERS_NOMBRE.' '.$this->persona->PERS_APATERNO.' '.$this->persona->PERS_AMATERNO,
        ];
    }
}
