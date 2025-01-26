<?php

namespace App\Http\Controllers\Seguridad\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuariosResponse extends JsonResource
{
    public function toArray($request)
    {
        return [
            
            'pers_codigo' => intval($this->PERS_CODIGO),
            'pers_nombre' => ($this->persona) ? $this->persona->PERS_NOMBRE : '',
            'pers_nombre_completo' => ($this->persona) ? $this->persona->PERS_NOMCOM : '',
            'pers_apaterno' => ($this->persona) ? $this->persona->PERS_APATERNO : '',
            'pers_amaterno' => ($this->persona) ? $this->persona->PERS_AMATERNO : '',
            'pers_tipodoc' => ($this->persona) ? $this->persona->PERS_TIPODOC : '',
            'pers_documento' => ($this->persona) ? $this->persona->PERS_DOCUMENTO : '',
            'pers_sexo' => ($this->persona) ? $this->persona->PERS_SEXO : '',
            'pers_fecnaci' => ($this->persona) ? $this->persona->PERS_FECNACI : '',
            'pers_direccion' => ($this->persona) ? $this->persona->PERS_DIRECCION : '',
            'pers_ocupacion' => ($this->persona) ? $this->persona->PERS_OCUPACION : '',

            'usua_codigo' => intval($this->USUA_CODIGO),
            'pers_documento' => ($this->persona) ? $this->persona->PERS_DOCUMENTO : '',
            'usua_username' => $this->USUA_USERNAME,
            'usua_estado' => intval($this->USUA_ESTADO),
            'estado' => intval($this->USUA_ESTADO),
            'perf_codigo' => intval($this->PERF_CODIGO),
            'perf_nombre' => $this->perfil->PERF_NOMBRE,
        ];
    }
}
