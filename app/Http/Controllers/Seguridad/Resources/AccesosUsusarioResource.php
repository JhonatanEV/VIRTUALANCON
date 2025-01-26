<?php

namespace App\Http\Controllers\Seguridad\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class AccesosUsusarioResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'PERF_CODIGO' => $this->PERF_CODIGO,
            'PERF_NOMBRE' => $this->PERF_NOMBRE,
            'PERF_NC_NOMBRE' => $this->PERF_NC_NOMBRE,
            'PERF_ESTADO' => $this->PERF_ESTADO,
            'OPCI_DIVIDIR' => optional(optional($this->permisos)->opciones)->OPCI_DIVIDIR,
            'OPCI_CODIGO' => optional(optional($this->permisos)->opciones)->OPCI_CODIGO,
            'OPCI_TIPO' => optional(optional($this->permisos)->opciones)->OPCI_TIPO,
            'OPCI_SUB_CODIGO' => optional(optional($this->permisos)->opciones)->OPCI_SUB_CODIGO,
            'OPCI_ICON' => optional(optional($this->permisos)->opciones)->OPCI_ICON,
            'OPCI_HREF' => optional(optional($this->permisos)->opciones)->OPCI_HREF,
            'OPCI_NOMBRE' => optional(optional($this->permisos)->opciones)->OPCI_NOMBRE,
            'OPCI_SUB_NOMBRE' => optional(optional($this->permisos)->opciones)->OPCI_SUB_NOMBRE,
            'OPCI_ICON_NOTIFICA' => optional(optional($this->permisos)->opciones)->OPCI_ICON_NOTIFICA,
            'OPCI_ORDER' => optional(optional($this->permisos)->opciones)->OPCI_ORDER,
            'OPCI_ESTADO' => optional(optional($this->permisos)->opciones)->OPCI_ESTADO,
        ];
    }

}
