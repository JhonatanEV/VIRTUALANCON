<?php

namespace App\Http\Controllers\Seguridad\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class AccesosUserResource extends JsonResource
{
    public function toArray($request)
    {
        return $this->opciones ? [
            'OPCI_CODIGO' => optional($this->opciones)->OPCI_CODIGO ?? 0,
            'OPCI_SUB_CODIGO' => optional($this->opciones)->OPCI_SUB_CODIGO ?? 0,
            'OPCI_TIPO' => optional($this->opciones)->OPCI_TIPO ?? 0,
            'OPCI_ICON' => optional($this->opciones)->OPCI_ICON ?? '',
            'OPCI_HREF' => optional($this->opciones)->OPCI_HREF ?? '',
            'OPCI_NOMBRE' => optional($this->opciones)->OPCI_NOMBRE ?? '',
            'OPCI_SUB_NOMBRE' => optional($this->opciones)->OPCI_SUB_NOMBRE ?? '',
            'OPCI_ICON_NOTIFICA' => optional($this->opciones)->OPCI_ICON_NOTIFICA ?? '',
            'OPCI_ORDER' => optional($this->opciones)->OPCI_ORDER ?? '',
            'OPCI_DIVIDIR' => optional($this->opciones)->OPCI_DIVIDIR ?? 0,
            'OPCI_ESTADO' => optional($this->opciones)->OPCI_ESTADO ?? 0
        ] : null;
    }
}