<?php

namespace App\Http\Controllers\Seguridad\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class AccesosUsuariosResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data = array_change_key_case($data, CASE_LOWER);
        return $data;
    }
}
