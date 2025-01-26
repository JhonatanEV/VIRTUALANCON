<?php

namespace App\Http\Controllers\Seguridad\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class PerfilResource extends JsonResource
{
    public function toArray($request)
    {   
        $data = parent::toArray($request);
        $data = array_change_key_case($data, CASE_LOWER);
        $data['perf_estado'] = intval($this->PERF_ESTADO);
        return $data;
    }
}
