<?php

namespace App\Http\Controllers\Seguridad\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class AccesosResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->ACCE_CODIGO,
            'opci_codigo' => $this->OPCI_CODIGO,
            'opci_nombres' => ($this->opciones) ? $this->opciones->PERS_NOMCOM : '',
            'usua_codigo' => $this->USUA_CODIGO,
            'estado' => $this->ACCE_ESTADO,
        ];
    }
}
