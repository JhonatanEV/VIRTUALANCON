<?php

namespace App\Http\Controllers\Seguridad\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class OpcionesResource extends JsonResource
{
    public function toArray($request)
    {   
        #$data = parent::toArray($request);
        #$data = array_change_key_case($data, CASE_LOWER);
        #$data['opci_sub_nombre'] = ($this->subOpcion) ? $this->subOpcion->OPCI_NOMBRE: '';

        return [
            'opci_codigo' => $this->OPCI_CODIGO,
            'opci_estado' => intval($this->OPCI_ESTADO),
            'opci_href' => $this->OPCI_HREF,
            'opci_icon' => $this->OPCI_ICON,
            'opci_icon_notifica' => $this->OPCI_ICON_NOTIFICA,
            'opci_nombre' => $this->OPCI_NOMBRE,
            'opci_order' => $this->OPCI_ORDER,
            'opci_sub_codigo' => $this->OPCI_SUB_CODIGO,
            'opci_sub_nombre' => ($this->subOpcion) ? $this->subOpcion->OPCI_NOMBRE: '',
            'opci_tipo' => intval($this->OPCI_TIPO)
        ];
    }
}
